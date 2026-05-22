<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('monitoring', function (User $user): bool {
    return in_array($user->role, ['admin', 'owner'], true);
});