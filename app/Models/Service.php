<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'profession_id',
        'price',
        'sale_price',
        'search_keywords',
        'is_visible',
        'min_time',
        'has_service_price',
        'charge_by',
        'title_en',
        'title_ru',
        'description_en',
        'description_ru',
    ];
}
