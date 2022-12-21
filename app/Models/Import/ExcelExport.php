<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ImportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CardImport;
use App\Constants\ExcelImport\ExcelStatus;
use App\Models\Import\ExcelImport;
use App\Models\Bank\CardTransaction;
use Storage;
use Carbon\Carbon;

class ExcelExport extends Model
{
    public static function ExcelExtract($file)
    {
       try{
           $payload = array();          
           if (empty(Storage::disk(config('excelimport.filesystem'))->exists($file->path))) {
               $payload['error_log'] = 'no file found';
               $payload['status'] = ExcelStatus::FAILED;
               ExcelImport::where('id',$file->id)->update($payload);
               return true;
           }

            $payload['status'] = ExcelStatus::IN_PROGRESS;
            $path = Storage::disk(config('excelimport.filesystem'))->path($file->path);

            $import = self::_moduleMethod($file->category_type); //Get Import class
            if(empty($import)){
                $payload['error_log'] = 'No module found';
                $payload['status'] = ExcelStatus::FAILED;
                ExcelImport::where('id', $file->id)->update($payload);
                return true;
            }

            $import->import($path);
            $error = array();
            foreach ($import->failures() as $failure) {
                $value =  $failure->values();                
                if (array_key_exists($failure->row(), $error) && array_key_exists("error", $error[$failure->row()])){
                    $value['error'] = $error[$failure->row()]['error']. ','. implode(", ", $failure->errors());
                }else{
                    $value['error'] = implode(", ", $failure->errors());
                 }                   
                 $error[$failure->row()] = $value;                 
            }
 
            //Store Json error data 
            $error_json = Storage::disk(config('excelimport.filesystem'))->exists(config('excelimport.json_upload_path').'/'.$file->id.'/error.json') ? json_decode(Storage::disk(config('excelimport.filesystem'))->get(config('excelimport.json_upload_path').'/'.$file->id.'/error.json')) : [];
            $error_file_path = config('excelimport.json_upload_path').'/'.$file->id.'/error.json';
            Storage::disk(config('excelimport.filesystem'))->put($error_file_path, json_encode($error,JSON_PRETTY_PRINT));

            //Store Json success data
            $successData = $import->get();
            $success_json = Storage::disk(config('excelimport.filesystem'))->exists(config('excelimport.json_upload_path').'/'.$file->id.'/success.json') ? json_decode(Storage::disk(config('excelimport.filesystem'))->get(config('excelimport.json_upload_path').'/'.$file->id.'/success.json')) : [];
            $success_file_path = config('excelimport.json_upload_path').'/'.$file->id.'/success.json';
            Storage::disk(config('excelimport.filesystem'))->put($success_file_path, json_encode($successData,JSON_PRETTY_PRINT));
            /*----------------------------------------*/

            \Log::info($file->id.' - Success data count - '.count($successData));
            \Log::info($file->id.' - Error data count - '.count($error));

            $process = $import->process(); 
            
            $payload['error_log'] = @json_encode($import->errors());
            $payload['status'] = isset($process['afterImport']['status']) ? $process['afterImport']['status'] : $process['beforeImport']['status'];
            if(count($successData) == 0){
                $payload['status'] = ExcelStatus::FAILED;
                $payload['error_log'] = 'Zero success records';
            }

            $payload['extract_start_date'] = $process['beforeImport']['extract_start_date'];
            $payload['extract_end_date'] = $process['afterImport']['extract_end_date'];
            $payload['failed_path'] = $error_file_path;
            $payload['success_path'] = $success_file_path;
            $payload['error_count'] = count($error);
            $payload['success_count'] = count($successData);
            
            ExcelImport::where('id', $file->id)->update($payload);

           return $payload;

       } catch ( ValidationException $e) {
                \Log::Error($e);
       }    
       
       return $payload;
       
    }   



    public static function _moduleMethod($fileModule){
        \Log::info($fileModule);
        $import = '';       
        switch ($fileModule) {
            case "CardSummaryReport":
                $import = new CardImport();
              break;           
            default:
                $import = '';
        }

        return $import;
    }

    public static function CardSummaryUpload($requestId)
    {  
        try{
            ExcelImport::where('id', $requestId)->update(['status' => ExcelStatus::IMPORTING, 'upload_start_date' => Carbon::now() ]);         
            $file = ExcelImport::where('id', $requestId)->first(); 
            $records =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($file->success_path),true);
            
            $successData = [];

            //Import in database
            foreach($records as $key => $value){
               
                $successData[] = [
                                'card_number'=> (int) $value['card_number'], 
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
            CardTransaction::insert($successData);
            //End insert

            ExcelImport::where('id', $requestId)->update(['status' => ExcelStatus::COMPLETED, 'upload_end_date' =>  Carbon::now()]);

        }catch(Exception $e) {
        
            return false;
        }  

        return true;
    }

}
