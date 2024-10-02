<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\ServiceService;
use GuzzleHttp\Psr7\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    /**
     * @param ServiceService $service
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Category $category
     * @return Category
     */
    public function index(Category $category): Category
    {
        return $this->productService->index($category);
    }

    public function show(Category $category, Product $product){
        return $this->productService->show($product);
    }
}
