<?php

namespace App\Listeners;

use App\Events\UpdateIntertextEvent;
use App\Models\Intertexts\Intertext;
use App\Models\Intertexts\IntertextTextEditing;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateIntertextTextEditing
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
     * @param  UpdateIntertextEvent  $event
     * @return void
     */
    public function handle(UpdateIntertextEvent $event)
    {

        $request = $event->request;

        $authors = collect($request->text_editing)->values();

        foreach($authors as $author)
        {
            $newAuthor = IntertextTextEditing::firstOrNew([
                "intertext_id" => $event->intertextId,
                "author_id" => $author
            ]);

            if (!$newAuthor->created_by)
                $newAuthor->created_by = Auth::user()->name;

            $newAuthor->updated_by = Auth::user()->name;

            $newAuthor->updated_at = Carbon::now();

            $newAuthor->save();
        }

        $intertextAuthors = Intertext::find($event->intertextId)->textEditing;
//        dd($intertextAuthors);

        // Delete items that have been deselected
        foreach ($intertextAuthors as $intertextAuthor)
        {
            if (!$authors->contains($intertextAuthor->author_id))
            {
                $intertextAuthor->delete();
            }
        }
    }
}
