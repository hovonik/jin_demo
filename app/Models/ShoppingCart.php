<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShoppingCart extends Model
{
    protected $fillable = [
        'user_id',
        'master_id',
        'is_primary',
        'total',
        'sale_total',
        'status',
        'address',
        'lat',
        'lng',
        'driver_id',
        'shop_id',
        'state',
        'place_in_date',
        'end_date',
        'start_lat',
        'start_long',
        'end_lat',
        'end_long',
        'distance_km',
        'shipping_price',
        'shipping_km',
        'cache_on_delivery',
        'rate'
    ];
    use HasFactory;

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(ShoppingCartProduct::class, 'shopping_cart_id');
    }

    /**
     * @return HasOne
     */
    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    /**
     * @return HasMany
     */
    public function cartProductService(): HasMany
    {
        return $this->hasMany(ShoppingCartService::class, 'shopping_cart_product_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function master(): HasOne
    {
        return $this->hasOne(Master::class, 'id', 'master_id');
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Master::class, 'id', 'driver_id');
    }

    /**
     * @return HasOne
     */
    public function cartService(): HasOne
    {
        return $this->hasOne(ShoppingCartService::class, 'shopping_cart_id', 'id');
    }
}
