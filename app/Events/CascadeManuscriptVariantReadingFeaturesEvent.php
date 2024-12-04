<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Manuskripte\Manuskript;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CascadeManuscriptVariantReadingFeaturesEvent extends Event
{
    use SerializesModels;

    public $manuskript;

    /**
     * Create a new event instance.
     *
     * @param Manuskript $manuskript
     */
    public function __construct(Manuskript $manuskript)
    {
        $this->manuskript = $manuskript;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
