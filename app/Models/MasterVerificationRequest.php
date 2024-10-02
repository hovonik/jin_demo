<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MasterVerificationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
      'master_id',
      'verified',
      'admin_decision_provided',
      'reason'
    ];

    public function files(){
        return $this->hasMany(MasterVerificationRequestFile::class);
    }

    /**
     * @return HasOne
     */
    public function master(): HasOne
    {
        return $this->hasOne(Master::class, 'id', 'master_id');
    }

}
