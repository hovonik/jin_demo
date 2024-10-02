<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductService extends Pivot
{
    protected $table = 'product_services';
    use HasFactory;
}
