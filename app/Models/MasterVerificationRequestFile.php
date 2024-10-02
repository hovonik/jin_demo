<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterVerificationRequestFile extends Model
{
    use HasFactory;

    protected $fillable = [
      'master_verification_request_id',
      'type',
      'car_texpassport_number',
      'image_url'
    ];
}
