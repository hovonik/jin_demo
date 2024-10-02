<?php

namespace App\Models;

use App\Constants\Parameters;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Master extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'is_courier',
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
        'busy',
        'current_lat',
        'current_long',
        'passport',
        'driver_license'
    ];

    protected $hidden = [
        'password',
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
     * @return BelongsToMany
     */
    public function professions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {

        return $this->belongsToMany(Profession::class, MasterProfession::class);
    }

    /**
     * @return bool
     */
    public function isNotVerified(): bool
    {
        return !$this->is_verified && !is_null($this->mobile_verify_code) || !is_null($this->mobile_verify_code_expires_at);
    }

    /**
     * @return bool
     */
    public function isVerifiedByAdmin(): bool
    {
        $this->load('verificationRequest');
        if (!empty($this->verificationRequest)){
            return $this->verificationRequest->verified && $this->verificationRequest->admin_decision_provided;
        }

        return false;
    }

    /**
     * @return HasMany
     */
    public function passwordResetCodes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PasswordResetCodes::class,'master_id','id');
    }
    /**
     * @return HasOne
     */
    public function inProcessOrder(): HasOne
    {
        return $this->hasOne(ShoppingCart::class, 'driver_id', 'id')
            ->where('state', '=', Parameters::STATES['accepted']);
    }

    /**
     * @return bool
     */
    public function isCourierOrDriver(): bool
    {
        return $this->is_courier === 1 || $this->professions->contains(Parameters::COURIER_PROFESSION_ID);
    }

    /**
     * @return HasOne
     */
    public function verificationRequest(): HasOne
    {
        return $this->hasOne(MasterVerificationRequest::class);
    }

    /**
     * @return bool
     */
    public function hasNewAdminVerificationRequest(): bool
    {
        $this->load('verificationRequest');
        if (!empty($this->verificationRequest)){
            if ($this->verificationRequest->admin_decision_provided == 0 && is_null($this->verificationRequest->reason)
                && !$this->verificationRequest->verified){
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasRejectedAdminVerificationRequest(): bool
    {
        $this->load('verificationRequest');
        if (!empty($this->verificationRequest)){
            if ($this->verificationRequest->admin_decision_provided == 1 && !is_null($this->verificationRequest->reason)
                && !$this->verificationRequest->verified){
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isNotVerifiedByAdmin(): bool
    {
        $this->load('verificationRequest');

        if (empty($this->verificationRequest)){
            return  true;
        }else{
            if (!empty($this->verificationRequest)){
                if (!$this->verificationRequest->verified){
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * @return HasMany
     */
    public function sentNotifications()
    {
        return $this->hasMany(SentNotification::class,'master_id','id');
    }
}
