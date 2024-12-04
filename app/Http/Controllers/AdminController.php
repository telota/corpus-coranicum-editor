<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::all();

        return view("manage.user.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();

        $action = array('App\Http\Controllers\AdminController@store');

        return view("manage.user.create_update", compact(["user", "action"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
        ]);

        // Create new user
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;

        $passwordReset = new PasswordReset();
        $passwordReset->email = $user->email;
        $passwordReset->token = "";
        $passwordReset->save();

        $password = Str::random(10);

        $user->password = Hash::make($password);

        Session::flash("flash_type", "alert-success");
        Session::flash("flash_message", "Neues Passwort: " . $password);

        $user->save();

        if ($request->roles) {
            // Attach roles
            foreach ($request->roles as $rolename) {
                $role = Role::where('name', $rolename)->first();
                $user->roles()->attach($role->id);
            }
        }

        Mail::send(["text" => "mails.registration_notification"], ['user' => $user], function ($message) use ($user) {
            $message->from("telotabot@bbaw.de", "CC-Edit");
            $message->to($user->email)->subject("CC-Edit Zugang - Mail 1");
            $message->bcc(Auth::user()->email)->subject("FYI: CC-Edit Account zugesandt - {$user->name}");
        });

        Mail::send(
            ["text" => "mails.registration_one_time_password"],
            ["user" => $user, "otp" => $password],
            function ($message) use ($user, $password) {
                $message->from("telotabot@bbaw.de", "CC-Edit");
                $message->to($user->email)->subject("CC-Edit Zugang - Mail 2");
                $message->bcc(Auth::user()->email)->subject("FYI: CC-Edit Passwort zugesandt - {$user->name}");
            });

        return redirect()->action([AdminController::class, 'show'], $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view("manage.user.show", compact("user"));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $action = array('App\Http\Controllers\AdminController@update', $id);

        return view("manage.user.create_update", compact("user", "action"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        if ($request->roles) {
            // Attach new roles
            foreach ($request->roles as $rolename) {
                $role = Role::where('name', $rolename)->first();

                if (!($user->hasRole($rolename))) {
                    $user->roles()->attach($role->id);
                }

            }
        }

        // Detach unwanted roles
        foreach ($user->roles as $userRole) {
            if (empty($request->roles) || !(in_array($userRole->name, $request->roles))) {
                $user->roles()->detach($userRole->id);
            }
        }

        return redirect()->action([AdminController::class, 'show'], $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Reset Password of a user
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setPasswordReset($id)
    {

        $user = User::find($id);

        $password = Str::random(10);

        Session::flash("flash_type", "alert-success");
        Session::flash("flash_message", "Neues Passwort: " . $password);

        $user->password = Hash::make($password);

        $passwordReset = new PasswordReset();
        $passwordReset->email = $user->email;
        $passwordReset->token = "";
        $passwordReset->save();

        $user->save();

        $user = User::find($id);
        Log::info($user->password);
        Log::info("Checking new password is equal to what is stored in db:" .
            $password);

        Log::info("Are they equal? " . Hash::check($password, $user->password));
        Log::info($user->password);

        return redirect()->action([AdminController::class, 'show'], $id);
    }
}
