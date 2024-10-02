<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\ProfessionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProfessionController extends Controller
{
    private ProfessionService $profession;

    public function __construct(ProfessionService $profession)
    {
        $this->profession = $profession;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->profession->index();
    }

    public function getProfessions(){
        return DB::table('services')
            ->select('profession_id')
            ->groupBy('profession_id')
            ->get()->pluck('profession_id');
    }
}
