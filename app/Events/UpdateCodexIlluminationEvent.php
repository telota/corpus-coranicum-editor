<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateCodexIlluminationEvent extends Event
{
    use SerializesModels;

    public $codexId;
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, $id)
    {

        $this->codexId = $id;
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