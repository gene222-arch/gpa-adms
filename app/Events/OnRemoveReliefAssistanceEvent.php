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

    public $volunteer;
    public $recipient;
    public $reliefGood;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $volunteer, User $recipient, ReliefGood $reliefGood)
    {
        $this->volunteer = $volunteer;
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
        return [
            new PrivateChannel('rcpt.relief-asst.receive.' . $this->recipient->id), // Recipient,
            new PrivateChannel('vol.relief-mngmt.on-process-and-create.' . $this->volunteer->id), // Volunteer
            new PrivateChannel('admin.dashboard.relief-assistance-mngmt.volunteers.1') //Super Admin,
        ];
    }

    public function broadcastWith()
    {
        return [
            'recipient_id' => $this->recipient->id,
            'relief_good_id' => $this->reliefGood->id
        ];
    }
}
