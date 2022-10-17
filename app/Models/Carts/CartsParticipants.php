<?php

namespace App\Models\Carts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartsParticipants extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id',
        'cart_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(cart::class);
    }
}
