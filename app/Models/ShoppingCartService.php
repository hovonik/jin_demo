<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShoppingCartService extends Model
{
    protected $fillable = [
        'shopping_cart_product_id',
        'service_id',
        'status',
        'time',
        'shopping_cart_id'
    ];
    use HasFactory;

    /**
     * @return HasOne
     */
    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

}
