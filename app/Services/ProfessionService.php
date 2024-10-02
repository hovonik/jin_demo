<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Profession;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ProfessionService
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $slug = request('slug');

        if($slug === 'all'){
            return Profession::query()->with(['service', 'children'])->where(['is_visible' => 1, 'parent_id' => null])->get();
        }

        return Profession::query()->with(['service', 'children'])->where(['is_visible' => 1, 'parent_id' => null, 'slug' => $slug])->get();
    }
}
