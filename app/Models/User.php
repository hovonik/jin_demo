<?php

namespace App\Models;

use App\Constants\Parameters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'is_verified',
        'address',
        'town',
        'city',
        'zip_code',
        'avatar',
        'mobile_verify_code_expires_at',
        'mobile_verify_code',
        'birthday',
        'fcm_token',
        'lang'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d'
    ];

    /**
     * Route notifications for the Vonage channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForVonage($notification)
    {
        return $this->phone;
    }

    /**
     * @return bool
     */
    public function isNotVerified(): bool
    {
        return !$this->is_verified && !is_null($this->mobile_verify_code) || !is_null($this->mobile_verify_code_expires_at);
    }

    /**
     * @return mixed
     */
    public function isVerified(): mixed
    {
        return $this->is_verified && is_null($this->mobile_verify_code) || is_null($this->mobile_verify_code_expires_at);
    }


    /**
     * @return HasMany
     */
    public function wishlistProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * @param int $product_id
     * @return bool
     */
    public function hasProductInWishList(int $product_id): bool
    {
        return !empty($this->wishlistProducts()->where('product_id', $product_id)->first());
    }

    /**
     * @return HasMany
     */
    public function passwordResetCodes(): HasMany
    {
        return $this->hasMany(PasswordResetCodes::class);
    }

    /**
     * @return Model|HasOne|null
     */
    public function primaryShoppingCart(): Model|HasOne|null
    {
        return $this->hasOne(ShoppingCart::class)->where(['is_primary' => 1, 'status' => Parameters::ACTIVE]);
    }

    /**
     * @return HasMany
     */
    public function sentNotifications(){
        return $this->hasMany(SentNotification::class,'user_id','id');
    }
}
