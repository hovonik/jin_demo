<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\SendVerifySMS;

class UserObserver
{
    public function created(User $user)
    {
        $user->notify(new SendVerifySMS());
    }
}
