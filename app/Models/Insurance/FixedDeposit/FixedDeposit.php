<?php

namespace App\Models\Insurance\FixedDeposit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Constants\ExcelImport\ExcelStatus;
use App\Models\Import\ExcelImport;
use Storage;
use Carbon\Carbon;


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


    public static function fixedDepositUpload($requestId)
    {  
        try {
            
            ExcelImport::where('id', $requestId)->update(['status' => ExcelStatus::IMPORTING, 'upload_start_date' => Carbon::now() ]);         
            $file = ExcelImport::where('id', $requestId)->first(); 
            $records =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($file->success_path),true);
            $successData = [];

            //Import in database
            foreach($records as $key => $value){               
                $successData[] = [
                                'allotment_date'=> $value['allotment_date'], 
                                'investor' =>   (string) $value['investor'], 
                                'entity' => (string) $value['entity'],
                                'pan' => (string) $value['pan'],
                                'fd_issuer' => (string) $value['fd_issuer'],
                                'tenure_months' => (int) $value['tenure_months'],
                                'tenure_days' => (int) $value['tenure_days'],
                                'amount' => (double) str_replace( ',', '',  $value['amount']),
                                'interest_rate' => (string) $value['interest_rate'],
                                'type' => (string) $value['type'],
                                'commission_in_rate' => (string) $value['commission_in_rate'],
                                'commission_out_rate' => (string) $value['commission_out_rate'],
                                'reference_number' => (string) $value['reference_number'],
                                'bank_name' => (string) $value['bank_name'],
                                'cheque_number' => (string) $value['cheque_number'],
                                'remarks' => (string) $value['remarks'],
                                'status' => (string) 'active',                                
                                'created_at' => Carbon::now(), 
                                'updated_at'=> Carbon::now()
                            ]; 
            }
            
            self::insert($successData); //End insert

            //Update status
            ExcelImport::where('id', $requestId)->update(['status' => ExcelStatus::COMPLETED, 'upload_end_date' =>  Carbon::now()]);

        }catch(Exception $e) {
            return false;
        }  

        return true;
    }

}
