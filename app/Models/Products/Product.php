<?php

namespace App\Models\Products;

use App\Models\Product\AddonOption;
use App\Models\Product\AddonOptionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Products\ProductInventory;
use App\Models\Products\ProductAddons;
use App\Models\Products\ProductCategories;
use App\Models\Stores\Store;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'parent_product_id',
        'store_id',
        'name',
        'descriptions',
        'sku',
        'price',
        'price_sale',
        'sale_start_date',
        'sale_end_date',
        'discount_id',
        'inventory_id',
        'tax_id',
        'categories_ids',
        'is_featured',
        'maximum_qty_per_order',
        'mimimum_qty_per_order',
        'status',
    ];
    /**
     * BelongsTo relation with ProductInventory 
     *
     * @return BelongsTo
     */
    public function productInventory(): BelongsTo
    {
        return $this->belongsTo(productInventory::class, 'inventory_id', 'id');
    }
    /**
     * HasMany relation with ProductAddOn
     *
     * @return HasMany
     */
    public function productAddons(): HasMany
    {
        return $this->hasMany(ProductAddons::class)->with('productAddonOption');
    }

    /**
     * BelongsTo relation with ProductCategories
     *
     * @return BelongsTo
     */
    public function productCategories(): BelongsTo
    {
        return $this->belongsTo(ProductCategories::class, 'categories_ids', 'id');
    }
    /**
     * HasMany relation with ProductAddonOption
     *
     * @return HasMany
     */
    public function productAddonOption()
    {
        return $this->hasMany(AddonOption::class);
    }


    public function getProductByStore($store_id)
    {
        return Model::where(function ($query) use ($store_id) {
            $query->where('store_id', '=', 0)
                ->orWhere('store_id', '=', $store_id);
        })->orderBy('id', 'ASC')->get();
    }



        /**
     * BelongsTo relation with Store 
     *
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

}
