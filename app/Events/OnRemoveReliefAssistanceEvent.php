<?php

namespace App\Events;

use App\Models\User;
use App\Models\ReliefGood;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class OnRemoveReliefAssistanceEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipient;
    public $reliefGood;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $recipient, ReliefGood $reliefGood)
    {
        $this->recipient = $recipient;
        $this->reliefGood = $reliefGood;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('rcpt.relief-asst.receive.' . $this->recipient->id);
    }

    public function broadcastWith()
    {
        return [
            'recipient_id' => $this->recipient->id,
            'relief_good_id' => $this->reliefGood->id
        ];
    }
}
