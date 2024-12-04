<?php

namespace App\Listeners;

use App\Events\UpdateIntertextCategoryEvent;
use App\Events\UpdateIntertextEvent;
use App\Models\Intertexts\CategoryInformationAuthor;
use App\Models\Intertexts\IntertextCategory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UpdateIntertextCategoryInformationAuthors
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
    public function handle(UpdateIntertextCategoryEvent $event)
    {

        $request = $event->request;

        $authors = collect($request->info_authors)->values();
//        dd(ManuscriptNew::getAuthors());
//        dd($authors);

        foreach($authors as $author)
        {
            $newAuthor = CategoryInformationAuthor::firstOrNew([
                "category_id" => $event->categoryId,
                "info_author_id" => $author
            ]);

            if (!$newAuthor->created_by)
                $newAuthor->created_by = Auth::user()->name;

            $newAuthor->updated_by = Auth::user()->name;

            $newAuthor->updated_at = Carbon::now();

            $newAuthor->save();

        }

        $categoryAuthors = IntertextCategory::find($event->categoryId)->infoAuthors;

        // Delete items that have been deselected
        foreach ($categoryAuthors as $categoryAuthor)
        {
            if (!$authors->contains($categoryAuthor->info_author_id))
            {
                $categoryAuthor->delete();
            }
        }
    }
}
