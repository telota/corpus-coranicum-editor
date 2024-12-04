<?php

namespace App\Console\Commands;

use App\Models\GeneralCC\CCRole;
use App\Models\GeneralCC\Module;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CreateRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-role {role} {module} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('name',$this->argument('user'))->firstOrFail();
        Auth::login($user);

        $module = Module::firstOrCreate([
            "module_name" => $this->argument('module'),
        ]);

        $role = CCRole::firstOrCreate([
            "role_name" => $this->argument('role'),
            "module_id" => $module->id,
        ]);

    }
}
