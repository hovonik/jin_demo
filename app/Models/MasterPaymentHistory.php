<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPaymentHistory extends Model
{
    use HasFactory;

    protected $table = 'master_payment_history';
    protected $fillable = [
        'status',
        'master_id',
        'amount',
        'type',
        'receiver_id'
    ];
}
