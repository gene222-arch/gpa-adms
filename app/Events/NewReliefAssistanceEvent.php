<?php

namespace App\Events;

use App\Models\ReliefGood;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewReliefAssistanceEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $reliefAssistanceInfo;
    public $volunteer;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReliefGood $reliefAssistanceInfo)
    {
        $this->reliefAssistanceInfo = $reliefAssistanceInfo;
        $this->volunteer = $this->reliefAssistanceInfo->users->first();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('rcpt.relief-asst.receive.' . $this->reliefAssistanceInfo->pivot->recipient_id),
            new PrivateChannel('admin.dashboard.relief-assistance-mngmt.volunteers.1') //Super Admin
        ];

    }

    public function broadcastWith()
    {
        return [
            'users' => [
                'id' => $this->volunteer->id,
                'name' => $this->volunteer->name,
                'email' => $this->volunteer->email,
            ],
            'id' => $this->reliefAssistanceInfo->id,
            'category' => $this->reliefAssistanceInfo->category,
            'name' => $this->reliefAssistanceInfo->name,
            'qty' => $this->reliefAssistanceInfo->quantity,
            'to' => $this->reliefAssistanceInfo->to,
            'created_at' => $this->reliefAssistanceInfo->created_at,
            'pivot' =>
            [
                'id' => $this->reliefAssistanceInfo->pivot->id,
                'user_id' => $this->reliefAssistanceInfo->pivot->user_id,
                'relief_good_id' => $this->reliefAssistanceInfo->pivot->relief_good_id,
                'recipient_id' => $this->reliefAssistanceInfo->pivot->recipient_id,
                'is_sent' => $this->reliefAssistanceInfo->pivot->is_sent,
                'sent_at' => $this->reliefAssistanceInfo->pivot->sent_at,
            ]
        ];
    }

}


/**
 * Todo Channel
 *
 * * PrivateChannel
 * ? If you only want to allow authenticate users to access this channel
 *
 * * Object data type
 * ? public
 * - One's the event is sent all of the properties with a public data type will be accessible
 * ? private
 * - The opposite of a 'public' property type, this hides the property
 * * Channel
 * ? If you want to allow non authenticated users to access this channel
 *
 */
