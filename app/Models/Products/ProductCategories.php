<?php

namespace App\Models\Products;

use App\Models\Stores\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'store_id',
        'parent_id',
        'name',
        'image',
        'status',
        'is_featured',
        'order_number',
        'description'
    ];

    /**
     * HasOne relation with Products
     *
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    
}
