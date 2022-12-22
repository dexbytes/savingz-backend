<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Constants\ExcelImport\ExcelStatus;
use App\Models\Import\ExcelImport;
use Storage;
use Carbon\Carbon;


class CardTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'card_id',
        'card_number',
        'txn_amount',
        'txn_type',
        'txn_available_balance',
        'txn_ledger_balance',
        'status',
        'txn_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public static function CardSummaryUpload($requestId)
    {  
        try {
            
            ExcelImport::where('id', $requestId)->update(['status' => ExcelStatus::IMPORTING, 'upload_start_date' => Carbon::now() ]);         
            $file = ExcelImport::where('id', $requestId)->first(); 
            $records =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($file->success_path),true);
            $successData = [];

            //Import in database
            foreach($records as $key => $value){               
                $successData[] = [
                                'card_number'=> (int) $value['card_number'], 
                                'card_id' => (int) $value['card_id'], 
                                'txn_amount' => (double) str_replace( ',', '',  $value['txn_amt']),
                                'txn_type' => (string) $value['txn_type'],
                                'txn_available_balance' => (double) str_replace( ',', '',  $value['available_balance']), 
                                'txn_ledger_balance' =>  (double)  str_replace( ',', '',  $value['ledger_balance']),
                                'status' => (string) $value['status'],
                                'txn_date' => $value['txn_date'], 
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
