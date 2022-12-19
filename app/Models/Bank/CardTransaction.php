<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardTransaction extends Model
{
    use HasFactory ;

    protected $fillable = [
        'id',
        'card_id',
        'card_number',
        'txn_amount',
        'txn_type',
        'txn_available_balance',
        'txn_ledger_balance',
        'status',
        'txn_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
  
    
}
