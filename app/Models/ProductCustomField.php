<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductCustomField extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'custom_field_id',
        'value',
        'value_en',
        'value_ru',
    ];

    /**
     * @return HasOne
     */
    public function custom_field(): HasOne
    {
        return $this->hasOne(CustomField::class, 'id', 'custom_field_id');
    }
}
