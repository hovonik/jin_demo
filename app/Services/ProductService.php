<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{

    /**
     * @param Category $category
     * @return Category
     */
    public function index(Category $category): Category
    {
        $min_price = request('min_price') ?? 0;
        $max_price = request('max_price') ?? 9999999999;
        $products = $category->load(['products' => function($query) use ($min_price, $max_price){
            return $query->where('is_visible', 1)->whereBetween('price', [$min_price, $max_price])->with('mainImage');
        }]);
        if(!empty($products['products'])){
            foreach ($products['products'] as $key => $product) {
                $products['products'][$key]['category_id'] = $products['id'];
            }
        }
        return $products;
    }

    public function show(Product $product){
        return $product->load(['services', 'shop', 'images', 'custom_fields.custom_field']);
    }
}
