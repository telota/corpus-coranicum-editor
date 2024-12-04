<?php

namespace App\Listeners;

use App\Events\UpdateManuscriptMappingsEvent;
use App\Models\Koranstelle;
use App\Models\Manuscripts\ManuscriptMapping;
use App\Models\Manuscripts\ManuscriptNew;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateManuscriptMappings
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

    public function handle(UpdateManuscriptMappingsEvent $event)
    {
        Artisan::call(\App\Console\Commands\UpdateManuscriptMappings::class, ["manuscript_id" => $event->manuscriptId]);

    }
}
