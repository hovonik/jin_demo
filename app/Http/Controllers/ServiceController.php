<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Services\ServiceService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private ServiceService $service;

    /**
     * @param ServiceService $service
     */
    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Profession $profession
     * @return Profession
     */
    public function index(Profession $profession): Profession
    {
        return $this->service->index($profession);
    }
}
