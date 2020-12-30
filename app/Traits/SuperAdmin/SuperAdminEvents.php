<?php

namespace App\Traits\SuperAdmin;

use App\Events\OnDispatchReliefAssistanceEvent;
use App\Events\OnUndispatchReliefAssistanceEvent;
use App\Events\OnRemoveReliefAssistanceEvent;

trait SuperAdminEvents
{

    public function onRemoveReliefAsstEvent(int $boolean, ...$args)
    {
        $boolean ? event(new OnRemoveReliefAssistanceEvent(...$args)) : '';
    }

    public function onDispatchReliefAsstEvent(int $boolean, ...$args)
    {
        $boolean ? event(new OnDispatchReliefAssistanceEvent(...$args)) : '';
    }

    public function onUndispatchReliefAsstEvent(int $boolean, ...$args)
    {
        $boolean ? event(new OnUndispatchReliefAssistanceEvent(...$args)) : '';
    }

}
