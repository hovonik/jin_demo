<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetCodes extends Model
{
    use HasFactory;

    protected $fillable = [
      'id','user_id','master_id','code','is_used'
    ];
}
