<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->categoryService->index();
    }
}
