<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profession extends Model
{

    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'parent_id',
        'is_visible',
        'slug',
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
        return $this->hasOne(Profession::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Profession::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function service(): HasMany
    {
        return $this->hasMany(Service::class, 'profession_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne(Profession::class, 'id', 'parent_id');
    }
}
