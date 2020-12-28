<?php

namespace App\Traits\Admins;

use App\Events\OnDispatchReliefAssistanceEvent;

trait SuperAdminEvents
{

    public function onDispatchReliefAsstEvent(int $boolean, ...$args)
    {
        $boolean ? event(new OnDispatchReliefAssistanceEvent(...$args)) : '';
    }

}
