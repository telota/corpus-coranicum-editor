<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateManuskriptEvent extends Event
{
    use SerializesModels;
    public $manuskriptId;
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, $manuskriptId)
    {

        $this->manuskriptId = $manuskriptId;
        $this->request = $request;

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
