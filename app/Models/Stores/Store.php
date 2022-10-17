<?php

namespace App\Models\Stores;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Stores\StoreAddress;
use App\Models\Stores\StoreMetaData;
use App\Models\Order\Order;
use App\Models\Product\AddonOption;
use App\Models\Product\Product;
use App\Models\Stores\StoreOwners;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'descriptions',
        'phone',
        'country_code',
        'email',
        'content',
        'order_preparing_time',
        'number_of_branch',
        'logo_path',
        'background_image_path',
        'status',
        'application_status',
        'is_open',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * HasOne relation with StoreAddress
     *
     * @return HasOne
     */
    public function storeAddress(): HasOne
    {
        return $this->hasOne(StoreAddress::class);
    }


      /**
     * HasOne relation with Product
     *
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }


    /**
     * HasMany relation with StoreMetaData
     *
     * @return HasMany
     */
    public function storeMetaData(): HasMany
    {
        return $this->hasMany(storeMetaData::class);
    }


    /**
     * HasMany relation with Order
     *
     * @return BelongsTo
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * HasMany relation with Order
     *
     * @return hasMany
     */
    public function productCategories(): HasMany
    {
        return $this->hasMany(productCategories::class);
    }

     /**
     * HasMany relation with Order
     *
     * @return hasMany
     */
    public function addOnOption(): HasMany
    {
        return $this->hasMany(AddonOption::class);
    }

    /**
     * HasOne relation with StoreMetaData
     *
     * @return HasOne
     */
    public function metadata(): HasOne
    {
        return $this->hasOne(storeMetaData::class);
    }



    /**
     * Get Meta data by key 
     *
     * @return Array
     */
    public function getMetadata($key)
    {
        if ($this->metadata()->where('key', '=', $key)->count()) {
            return $this->getValueAttribute($this->metadata()->where('key', '=', $key)->first()->value);
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
            $this->attributes['value'] = json_encode($value);
            return;
        }

        $this->attributes['value'] = $value;
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
    public function getBusinessHours()
    {
        $businessHours = $this->getMetadata('business_hours');

        if (is_array($businessHours)) {

            foreach ($businessHours as $key => $value) {
                $businessHours[$key]['closing_time'] = (int) $value['closing_time'];
                $businessHours[$key]['opening_time'] = (int) $value['opening_time'];
                $businessHours[$key]['opening_time_format'] = intdiv($value['opening_time'], 60) . ':' . ($value['opening_time'] % 60);
                $businessHours[$key]['closing_time_format'] = intdiv($value['closing_time'], 60) . ':' . ($value['closing_time'] % 60);
            }

            return $businessHours;
        }

        return [];
    }


    public function getDefaultBusinessHours()
    {
        $storeOpeningHoursArray = [
            [
                'status'    => 1,
                'days'  => 'Monday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ],
            [
                'status'    => 1,
                'days'  => 'Tuesday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ],
            [
                'status'    => 1,
                'days'  => 'Wednesday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ],
            [
                'status'    => 1,
                'days'  => 'Thursday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ],
            [
                'status'    => 1,
                'days'  => 'Friday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ],
            [
                'status'    => 1,
                'days'  => 'Saturday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ],
            [
                'status'    => 1,
                'days'  => 'Sunday',
                'opening_time'  => '480',
                'closing_time'  => '1200',
            ]
        ];

        return json_encode($storeOpeningHoursArray);
    }
}
