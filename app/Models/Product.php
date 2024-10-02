<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'code',
        'description',
        'price',
        'sale_price',
        'count',
        'unit',
        'search_keywords',
        'is_visible',
        'shop_id',
        'title_en',
        'title_ru',
        'description_en',
        'description_ru',
    ];

    /**
     * @return HasMany
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * @return BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            ProductService::class,
            'product_id',
            'service_id',
            'id',
            'id',
        )->using(ProductService::class)->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            CategoryProduct::class,
            'product_id',
            'category_id',
            'id',
            'id',
        )->using(CategoryProduct::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function mainImage(): HasOne
    {
        return $this->hasOne(Image::class, 'product_id', 'id')->where('is_primary', 1);
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
    public function custom_fields(): HasMany
    {
        return $this->hasMany(ProductCustomField::class);
    }

}
