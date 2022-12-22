<?php

namespace App\Models\Insurance\FixedDeposit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FixedDeposit extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'id',
       'allotment_datedate',
       'investor',
       'entity',
       'pan',
       'fd_issuer',
       'tenure_months',
       'tenure_days',
       'amount',
       'interest_rate',
       'type',
       'commission_in_rate',
       'commission_out_rate',
       'reference_number',
       'bank_name',
       'cheque_number',
       'remarks',
       'status',
   ];
   
    /**
     * BelongsTo relation with UserFixedDeposit
     *
     * @return BelongsTo
     */
    public function UserFixedDeposit(): BelongsTo
    {
        return $this->belongsTo(UserFixedDeposit::class,'id','fixed_deposit_id');
    }

}
