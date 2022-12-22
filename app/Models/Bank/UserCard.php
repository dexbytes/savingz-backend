<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCard extends Model
{
    use HasFactory ;

    protected $fillable = [
        'id',
        'user_id',
        'card_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
  
    /**
     * BelongsTo relation with store
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
