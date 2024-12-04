<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private function isSharable(
        $image_online,
        $page_online,
        $manuscript_online,
        $old_manuscript_online
    )
    {
        if ($image_online == 0) {
            return false;
        }
        if ($page_online == 1 || $manuscript_online == 1) {
            return false;
        }
        if ($manuscript_online == 0 && $old_manuscript_online == 'ohneBild') {
            return false;
        }

        return true;

    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('ms_manuscript_pages_images', function (Blueprint $table) {
            $table->after('manuscript_page_id', function (Blueprint $table) {
                $table->boolean('private_use_only');
            });
        });

        $user = User::where('name','DATA_MIGRATION')->first();
        Auth::login($user);

        $images = \App\Models\Manuscripts\ManuscriptPageImage::with(
            ['page.manuscript']
        )->get();

        $oldManuscripts = \App\Models\Manuskripte\Manuskript::all()->keyBy('ID');


        foreach ($images as $image) {

            Log::info("Image " . $image->id . " is online: " . $image->is_online);
            Log::info("Image Page " . $image->page->id . " is online: " . $image->page->is_online);
            Log::info("Manuscript" . $image->page->manuscript->id . " is online: " . $image->page->manuscript->is_online);
            $oldManuscriptOnline = null;
            if (isset($oldManuscripts[$image->page->manuscript->id])) {
                $oldManuscriptOnline = $oldManuscripts[$image->page->manuscript->id]->webtauglich;
                Log::info("Old Manuscript " . $image->page->manuscript->id . "is online : " . $oldManuscriptOnline);

            }

            $isSharable = $this->isSharable(
                $image->is_online,
                $image->page->is_online,
                $image->page->manuscript->is_online,
                $oldManuscriptOnline,
            );

            $image->private_use_only = !$isSharable;
            $image->updated_by = "DATA_MIGRATION";

            Log::info("Private use only: " . $image->private_use_only);
            $image->save();

        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_manuscript_pages_images', function (Blueprint $table) {
            if (Schema::hasColumn('ms_manuscript_pages_images', 'private_use_only')) {
                $table->dropColumn('private_use_only');
            }
        });
    }
};
