<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * @property  classifications
 * @property  codexId
 */
class UpdateCodexClassificationsEvent extends Event
{

    public $classifications;
    public $codexId;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param $classifications
     * @param $codexId
     */
    public function __construct($classifications, $codexId)
    {

        $this->classifications = $classifications;
        $this->codexId = $codexId;

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
