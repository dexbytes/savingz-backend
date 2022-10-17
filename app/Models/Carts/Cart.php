<?php

namespace App\Models\Carts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'cart_number',
        'session_id',
        'token',
        'status',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($cart_number) {
            $cart_number->cart_number = rand(10000000,99999999);
        });
        
    }

    public function createSlug($cart_number){
        do {
            $code = rand(10000000,99999999);
        } while (Cart::whereCartNumber($code)->exists());
    }

    public function cartItem(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function cartParticipants(): HasMany
    {
        return $this->hasMany(CartsParticipants::class, 'cart_id');
    }
}   
