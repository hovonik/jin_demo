<?php

namespace App\Observers;

use App\Models\Master;
use App\Notifications\SendVerifySMS;

class MasterObserver
{
    public function created(Master $master)
    {
        $master->notify(new SendVerifySMS());
    }
}
