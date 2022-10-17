<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Stores\Store;
use App\Models\Order\OrderMeta;
use App\Models\Order\OrderProduct;
use App\Models\User;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'order_number',
        'user_id',
        'store_id',
        'total_items',
        'shipping_method_id',
        'sub_total_amount',
        'discount_amount',
        'delivery_amount',
        'tax_amount',
        'total_amount',
        'order_status',
        'comments',
        'ip_address',
        'latitude',
        'longitude',
        'promo_code',
        'promo_code_id ',
        'is_sharing_order',
        'content',
        'is_scheduled',
        'scheduled_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * BelongsTo relation with store 
     *
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    /**
     * BelongsTo relation with store 
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * HasMany relation with OrderMeta
     *
     * @return HasMany
     */
    public function orderMeta(): HasMany
    {
        return $this->hasMany(OrderMeta::class);
    }

    /**
     * HasMany relation with OrderMeta
     *
     * @return HasMany
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * HasMany relation with OrderMeta
     *
     * @return HasOne
     */
    public function metadata(): HasOne
    {
        return $this->hasOne(OrderMeta::class);
    }

    /**
     * HasMany relation with Store
     *
     * @return HasOne
     */
    public function storeData(): HasOne
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }

    /**
     * Get Meta data by key 
     *
     * @return Array
     */
    public function getMetadata($key)
    {
        if ($this->metadata()->where('order_key', '=', $key)->count()) {
            return $this->getValueAttribute($this->metadata()->where('order_key', '=', $key)->first()->order_values);
        }

        return null;
    }

    /**
     * Get Meta data by key 
     *
     * @return Array,
     */
    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['order_values'] = json_encode($value);
            return;
        }

        $this->attributes['order_values'] = $value;
    }

    public function getValueAttribute($value)
    {
        $decodeValue = json_decode($value, true);

        if (is_array($decodeValue)) {
            return $decodeValue;
        }

        return $value;
    }

    /**
     * Get Business Houes 
     *
     * @return Array
     */
    public function getShippingAddress()
    {
        $businessHours = $this->getMetadata('shipping_address');

        if (is_array($businessHours)) {
            return $businessHours;
        }

        return [];
    }
}
