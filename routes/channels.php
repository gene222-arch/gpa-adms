<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('rcpt.relief-asst.receive.{id}', function ($user, $id) {
    return true;
});

Broadcast::channel('vol.relief-mngmt.on-process-and-create.{id}', function ($user, $id) {
    return true;
});


Broadcast::channel('admin.dashboard.relief-assistance-mngmt.volunteers.{superAdminId}', function ($user, $id) {
    return true;
}, ['guards' => 'admin']);

