<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProfession extends Model
{
    use HasFactory;

    protected $fillable = ['master_id','profession_id'];
}
