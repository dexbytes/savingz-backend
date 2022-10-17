<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'order_id',
        'user_id',
        'store_id',
        'wallet_id',
        'amount',
        'payment_method_code',
        'transaction_type',
        'payment_mode',
        'status',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
}
