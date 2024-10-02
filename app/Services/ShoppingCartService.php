<?php

namespace App\Services;

use App\Constants\Parameters;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\AddToCartServiceRequest;
use App\Models\Master;
use App\Models\MasterProfession;
use App\Models\Product;
use App\Models\SentNotification;
use App\Models\Service;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ShoppingCartService
{

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return Auth::user()->load([
                'primaryShoppingCart' => [
                    'products' => function ($query) {
                        return $query->with([
                            'product' => function ($query) {
                                return $query->with('mainImage');
                            },
                            'services' => function ($query) {
                                return $query->with('service');
                            }
                        ])->where(['status' => Parameters::ACTIVE]);

                    },
                    'shop'
                ],
            ]
        );
    }

    public function show(Product $product)
    {
        return;
    }

    /**
     * @param AddToCartRequest $request
     * @return JsonResponse
     */
    public function store(AddToCartRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $product_id = $data['product_id'];
            $shop_id = Product::query()->where('id', $product_id)->first()->shop_id;
            DB::beginTransaction();
            if ($request->get('shopping_cart_id')) {
                $shopping_cart = ShoppingCart::query()->where(['id' => $request->get('shopping_cart_id'), 'status' => 'active'])->first();
                if($shop_id != $shopping_cart->shop_id){
                    $shopping_cart->update(['status' => Parameters::CLOSED]);
                    $shopping_cart = ShoppingCart::query()->create([
                        'user_id' => Auth::id(),
                        'shop_id' => $shop_id,
                        'is_primary' => $data['is_primary'],
                        'status' => Parameters::ACTIVE
                    ]);
                }

            }else{
                $shopping_cart = ShoppingCart::query()->create([
                    'user_id' => Auth::id(),
                    'shop_id' => $shop_id,
                    'is_primary' => $data['is_primary'],
                    'status' => Parameters::ACTIVE
                ]);
            }

            $shopping_cart_id = $shopping_cart->id;

            $shopping_cart_product = ShoppingCartProduct::query()->create([
                'shopping_cart_id' => $shopping_cart_id,
                'product_id' => $product_id,
                'count' => $data['count'],
                'status' => Parameters::ACTIVE
            ]);
            if ($data['services']) {
                $services = $data['services'];
                $shopping_cart_product_id = $shopping_cart_product->id;
                if (!$this->connectServices($services, $shopping_cart_product_id)) {
                    DB::rollBack();
                    return response()->json(['message' => 'service not connected', 500]);
                };
            }

            $shopping_cart->update($this->calculateCart($data, $shopping_cart));

            DB::commit();
            return response()->json([ShoppingCart::query()->where('id', $shopping_cart_id)->with(['products' => function ($query) {
                return $query->with([
                    'product' => function ($query) {
                        return $query->with('mainImage');
                    },
                    'services' => function ($query) {
                        return $query->with('service');
                    }
                ])->where('status', Parameters::ACTIVE);

            }, 'shop' ])->first(), 200]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([$e->getMessage(), 500]);
        }

    }

    public function itemHasInCart(Request $request)
    {
        $item_id = $request->get('item_id');
        return Auth::user()->load([
                'primaryShoppingCart' => [
                    'products' => function ($query) use ($item_id) {
                        return $query->with([
                            'product' => function ($query) {
                                return $query->with('mainImage');
                            },
                            'services' => function ($query) {
                                return $query->with('service');
                            }
                        ])->where(['status' => Parameters::ACTIVE, 'product_id' => $item_id]);
                    },
                ],
            ]
        );
    }

    /**
     * @param AddToCartRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(AddToCartRequest $request, $id): JsonResponse
    {
        $shopping_cart = ShoppingCart::query()->where(['id' => $id, 'status' => 'active'])->first();
        $data = $request->validated();
        try {
            DB::beginTransaction();
            $shopping_cart->update($this->calculateCart($data, $shopping_cart));
            $shopping_cart_product = ShoppingCartProduct::query()->where(['shopping_cart_id' => $shopping_cart->id, 'product_id' => $data['product_id']]);
            $shopping_cart_product->update(['count' => $data['count']]);
            $shopping_cart_product = $shopping_cart_product->first();
            $shopping_cart_product_id = $shopping_cart_product->id;
            \App\Models\ShoppingCartService::query()->where('shopping_cart_product_id', $shopping_cart_product_id)->delete();

            if ($data['services']) {
                $services = $data['services'];
                if (!$this->connectServices($services, $shopping_cart_product_id)) {
                    DB::rollBack();
                    return response()->json(['message' => 'service not connected', 500]);
                };
            }

            DB::commit();
            return response()->json([$shopping_cart, 200]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([['error' => [$e->getMessage(), $e->getLine()]], 500]);
        }
    }

    /**
     * @param $data
     * @return array
     */
    private function calculateCart($data, $shopping_cart): array
    {
        $prices = [];
        $product = Product::query()->where('id', $data['product_id'])->first();
        $total = $shopping_cart->total + $product->price * $data['count'];
        $sale_total = $shopping_cart->sale_total + $product->sale_price * $data['count'];
        if ($data['services']) {
            foreach ($data['services'] as $service_id) {
                $service = Service::query()->where('id', $service_id)->first();
                $total += $service->price;
                $sale_total += $service->sale_price;
            }
        }

        $prices['total'] = $total;
        $prices['sale_total'] = $sale_total;

        return $prices;
    }

    /**
     * @param $services
     * @param $shopping_cart_product_id
     * @return bool
     */
    private function connectServices($services, $shopping_cart_product_id): bool
    {
        $creating_data = [];
        foreach ($services as $service_id) {
            $creating_data[] = [
                'shopping_cart_product_id' => $shopping_cart_product_id,
                'service_id' => $service_id,
                'status' => Parameters::ACTIVE
            ];
        }
        try {
            \App\Models\ShoppingCartService::query()->insert($creating_data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $service_id
     * @return JsonResponse
     */
    public function addToCartService(AddToCartServiceRequest $addToCartServiceRequest): JsonResponse
    {
        $service_id = $addToCartServiceRequest->get('service_id');
        $prof_id = Service::query()->where('id', $service_id)->first()->profession_id;
        if (!MasterProfession::query()->where('profession_id', $prof_id)->first()) {
            return response()->json([['error' => ['Master not found']], 404]);
        }
        try {
            DB::beginTransaction();
            $service_price = Service::query()->where('id', $service_id)->first()->price;
            $time = $addToCartServiceRequest->get('time');

            if($time){
                $service_price = $time * $service_price;
            }

            $shopping_cart = ShoppingCart::query()->create([
                'user_id' => Auth::id(),
                'is_primary' => 0,
                'total' => $service_price,
                'status' => Parameters::ACTIVE
            ]);

            \App\Models\ShoppingCartService::query()->create([
                'shopping_cart_id' => $shopping_cart->id,
                'service_id' => $service_id,
                'time' => $time,
                'status' => Parameters::ACTIVE
            ]);

            DB::commit();
            return response()->json([$shopping_cart->load('cartService.service'), 200]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([['error' => [$e->getMessage(), $e->getLine()]], 500]);
        }
    }

}
