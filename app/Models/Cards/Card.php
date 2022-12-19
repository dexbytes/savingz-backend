<?php

namespace App\Models\Cards;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory ;

    protected $fillable = [
        'id',
        'card_number',
        'expiration_year',
        'expiration_month',
        'card_holder_name',
        'status',
        'is_assigned',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
  
    
}
