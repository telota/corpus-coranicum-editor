<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UpdateIntertextCategoryEvent;
use App\Events\UpdateIntertextEvent;
use App\Events\UpdateIntertextSourceAuthorEvent;
use App\Events\UpdateIntertextSourceEvent;
use App\Events\UpdateManuskriptEvent;
use App\Listeners\UpdateIntertextTextEditing;
use App\Listeners\UpdateIntertextCategoryInformationAuthors;
use App\Listeners\UpdateIntertextCollaborators;
use App\Listeners\UpdateIntertextSourceAuthorInformationAuthors;
use App\Listeners\UpdateIntertextSourceInformationAuthors;
use App\Listeners\UpdateIntertextUpdaters;
use App\Listeners\UpdateManuscriptReadingSignsFunction;
use App\Listeners\UpdateManuscriptMappings;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UpdateManuskriptEvent::class => [
            UpdateManuscriptReadingSignsFunction::class,
        ],
        UpdateIntertextEvent::class => [
            UpdateIntertextAuthors::class,
            UpdateIntertextCollaborators::class,
            UpdateIntertextUpdaters::class,
            UpdateIntertextTextEditing::class
        ],
        UpdateIntertextSourceEvent::class => [
            UpdateIntertextSourceInformationAuthors::class
        ],
        UpdateIntertextCategoryEvent::class => [
            UpdateIntertextCategoryInformationAuthors::class
        ],
        UpdateIntertextSourceAuthorEvent::class => [
            UpdateIntertextSourceAuthorInformationAuthors::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
