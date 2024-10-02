<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WishListService
{
    /**
     * @return Collection|array
     */
    public function getWishListData(): Collection|array
    {
        $products = Product::query()->with('categories')->with('mainImage')->whereHas('wishlists', function ($query) {
            return $query->whereBelongsTo(Auth::user());
        })->get();
        foreach ($products as $key => $product){
            $category_id = 0;
            if(!empty($product['categories'][0])){
                $category_id = $product['categories'][0]['id'];
            }
            unset($products[$key]['categories']);
            $products[$key]['category_id'] = $category_id;
        }
        return $products;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function addToWishList(array $request): mixed
    {
        if (Auth::user()->hasProductInWishList($request['product_id'])) {
            return Response::json([
                'error' => [
                    'am' => 'Տվյալ ապրանքն արդեն կա նախընտրելիների ցանկում',
                    'en' => 'Item is already added to wishlist',
                    'ru' => 'Продукт уже находится в списке желаемых'
                ]
            ]);
        }
        Auth::user()->wishlistProducts()->create($request);

        return Auth::user()->wishlistProducts()->latest()->first();
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function remove(array $request): mixed
    {
        return Auth::user()->wishlistProducts()->where('product_id', $request['product_id'])->delete();
    }

    /**
     * @return mixed
     */
    public function emptyWishlist(): mixed
    {
        return Auth::user()->wishlistProducts()->delete();
    }
}
