<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Category::query()->with('children')->where(['is_visible' => 1, 'parent_id' => null])->get();
    }
}
