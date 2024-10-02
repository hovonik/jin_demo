<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'admin_id',
        'title',
        'description',
        'product_count',
        'search_keywords',
        'is_visible',
        'admin_id',
        'title_en',
        'title_ru',
        'description_en',
        'description_ru',
    ];

    /**
     * @return HasOne
     */
    public function child(): HasOne
    {
        return $this->hasOne(Category::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            CategoryProduct::class,
            'category_id',
            'product_id',
        )->using(CategoryProduct::class)->withTimestamps();
    }
}
