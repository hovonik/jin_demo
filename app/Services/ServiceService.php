<?php

namespace App\Services;

use App\Models\Profession;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ServiceService
{
    /**
     * @param Profession $profession
     * @return Profession
     */
    public function index(Profession $profession): Profession
    {
        $profession->load(['service' => function($query){
            return $query->where('is_visible', 1);
        }]);

        foreach ($profession->service as $key => $service){
            $profession->service[$key]['chat_supported'] = 1;
        }
        return $profession;
    }
}
