<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
      'id',
      'user_id',
      'master_id',
      'shopping_cart_id',
      'title'
    ];

    public function order(){
        return $this->belongsTo(ShoppingCart::class,'shopping_cart_id', 'id');
    }
}
