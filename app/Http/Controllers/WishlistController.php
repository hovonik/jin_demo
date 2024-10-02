<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemToWishListRequest;
use App\Services\WishListService;
use Illuminate\Database\Eloquent\Collection;

class WishlistController extends Controller
{
    private $service;

    public function __construct(WishListService $wishListService)
    {
        $this->service = $wishListService;
    }

    /**
     * @return Collection|array
     */
    public function index(): Collection|array
    {
        return $this->service->getWishListData();
    }

    /**
     * @param AddItemToWishListRequest $request
     * @return mixed
     */
    public function add(AddItemToWishListRequest $request): mixed
    {
        return $this->service->addToWishList($request->validated());
    }

    /**
     * @param AddItemToWishListRequest $request
     * @return mixed
     */
    public function removeItem(AddItemToWishListRequest $request): mixed
    {
        return $this->service->remove($request->validated());
    }

    /**
     * @return mixed
     */
    public function emptyWishlist(): mixed
    {
        return $this->service->emptyWishlist();
    }
}
