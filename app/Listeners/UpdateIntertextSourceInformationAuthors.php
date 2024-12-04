<?php

namespace App\Listeners;

use App\Events\UpdateIntertextEvent;
use App\Events\UpdateIntertextSourceEvent;
use App\Models\Intertexts\IntertextSource;
use App\Models\Intertexts\SourceInformationAuthor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UpdateIntertextSourceInformationAuthors
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
    public function handle(UpdateIntertextSourceEvent $event)
    {

        $request = $event->request;

        $authors = collect($request->info_authors)->values();
//        dd(ManuscriptNew::getAuthors());
//        dd($authors);

        foreach($authors as $author)
        {
            $newAuthor = SourceInformationAuthor::firstOrNew([
                "source_id" => $event->sourceId,
                "info_author_id" => $author
            ]);

            if (!$newAuthor->created_by)
                $newAuthor->created_by = Auth::user()->name;

            $newAuthor->updated_by = Auth::user()->name;

            $newAuthor->updated_at = Carbon::now();

            $newAuthor->save();

        }

        $sourceInfoAuthors = IntertextSource::find($event->sourceId)->infoAuthors;

        // Delete items that have been deselected
        foreach ($sourceInfoAuthors as $infoAuthor)
        {
            if (!$authors->contains($infoAuthor->info_author_id))
            {
                $infoAuthor->delete();
            }
        }
    }
}
