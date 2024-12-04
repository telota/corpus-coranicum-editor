<?php

namespace App\Listeners;

use App\Events\UpdateManuskriptEvent;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptReadingSignsFunction;
use App\Models\Manuscripts\ManuscriptRecitationSignsFunction;
use App\Models\Manuscripts\ManuskriptVowelSigns;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateManuscriptReadingSignsFunction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateManuskriptEvent  $event
     * @return void
     */
    public function handle(UpdateManuskriptEvent $event)
    {

        $request = $event->request;
        $functions = collect($request->reading_signs_functions)->values();

        foreach($functions as $function)
        {


            $newFunction = ManuscriptReadingSignsFunction::firstOrNew([
                "manuscript_id" => $event->manuskriptId,
                "reading_sign_function" => $function
            ]);

            if (!$newFunction->created_by)
                $newFunction->created_by = Auth::user()->name;

            $newFunction->updated_by = Auth::user()->name;

            $newFunction->updated_at = Carbon::now();

            $newFunction->save();
        }

        $manuscriptFunctions = ManuscriptNew::find($event->manuskriptId)->readingSignsFunctions;

        // Delete items that have been deselected
        foreach ($manuscriptFunctions as $manuscriptFunction)
        {
            if (!$functions->contains($manuscriptFunction->reading_sign_function))
            {
                $manuscriptFunction->delete();
            }
        }
    }
}
