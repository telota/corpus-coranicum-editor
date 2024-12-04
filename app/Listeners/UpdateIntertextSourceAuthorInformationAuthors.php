<?php

namespace App\Listeners;

use App\Events\UpdateIntertextEvent;
use App\Events\UpdateIntertextSourceAuthorEvent;
use App\Models\Intertexts\SourceAuthor;
use App\Models\Intertexts\SourceAuthorInformationAuthor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UpdateIntertextSourceAuthorInformationAuthors
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
    public function handle(UpdateIntertextSourceAuthorEvent $event)
    {

        $request = $event->request;

        $authors = collect($request->info_authors)->values();

        foreach($authors as $author)
        {
            $newAuthor = SourceAuthorInformationAuthor::firstOrNew([
                "author_id" => $event->authorId,
                "info_author_id" => $author
            ]);

            if (!$newAuthor->created_by)
                $newAuthor->created_by = Auth::user()->name;

            $newAuthor->updated_by = Auth::user()->name;

            $newAuthor->updated_at = Carbon::now();

            $newAuthor->save();

        }
        $sourceAuthorInfoAuthors = SourceAuthor::find($event->authorId)->infoAuthors;
//        dd($sourceAuthorInfoAuthors);

        // Delete items that have been deselected
        foreach ($sourceAuthorInfoAuthors as $sourceAuthorInfoAuthor)
        {
            if (!$authors->contains($sourceAuthorInfoAuthor->info_author_id))
            {
                $sourceAuthorInfoAuthor->delete();
            }
        }
    }
}
