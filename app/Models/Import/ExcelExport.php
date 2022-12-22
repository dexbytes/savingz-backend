<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ImportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Constants\ExcelImport\ExcelStatus;
use App\Models\Import\ExcelImport;
use App\Imports\CardImport;
use App\Imports\FixedDepositImport;
use Storage;
use Carbon\Carbon;
use App\Models\Bank\Card;
use App\Models\Bank\CardTransaction;

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

            //Errro data prepare
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
           
            //Success data prepare
            $successData = self::_getSuccessData($file->category_type, $import);
      
            //Store Json error data 
            $error_json = Storage::disk(config('excelimport.filesystem'))->exists(config('excelimport.json_upload_path').'/'.$file->id.'/error.json') ? json_decode(Storage::disk(config('excelimport.filesystem'))->get(config('excelimport.json_upload_path').'/'.$file->id.'/error.json')) : [];
            $error_file_path = config('excelimport.json_upload_path').'/'.$file->id.'/error.json';
            Storage::disk(config('excelimport.filesystem'))->put($error_file_path, json_encode($error,JSON_PRETTY_PRINT));

            //Store Json success data          
            $success_json = Storage::disk(config('excelimport.filesystem'))->exists(config('excelimport.json_upload_path').'/'.$file->id.'/success.json') ? json_decode(Storage::disk(config('excelimport.filesystem'))->get(config('excelimport.json_upload_path').'/'.$file->id.'/success.json')) : [];
            $success_file_path = config('excelimport.json_upload_path').'/'.$file->id.'/success.json';
            Storage::disk(config('excelimport.filesystem'))->put($success_file_path, json_encode($successData,JSON_PRETTY_PRINT));
            /*----------------------------------------*/
      
            //Procceed now
            $process = $import->process(); 
            
            //Prepare database insert data
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

       } catch (Exception $e) {
            \Log::Error($e);
       }    
       
       return $payload;
    }   


    public static function _getSuccessData($fileModule, $import){
        $successData = [];
       
        switch ($fileModule) {
            case "CardSummaryReport":
                $successData = self::_getCardSuccessData($import);
            break; 
            case "fixed-deposit":
                $successData = self::_getFixedDepositSuccessData($import);
            break;          
            default:
        }

       return  $successData;
    }


    public static function _getFixedDepositSuccessData($import){
        $successData = [];
        
        foreach ($import->get() as $sdKey => $successValue) {  
           $successData[] = $successValue;
        }

        return $successData;
    }


    public static function _getCardSuccessData($import){
        $successData = [];
        $cardsInImportsData = [];      

        foreach ($import->get() as $sdKey => $successValue) {  
            $successValue['card_number'] = (int) $successValue['card_number'];             
            $cardNumber =  $successValue['card_number'];
            if (false == $key = array_search($cardNumber, $cardsInImportsData)) {             
                $card = Card::where('card_number', $cardNumber)->first();
                if ($card) {
                    $cardsInImportsData[$cardNumber]  = $card->id;
                }else{
                    $cardsInImportsData[$cardNumber]  = '';
                }
            }  

            if(!array_key_exists($cardNumber, $cardsInImportsData) || empty($cardsInImportsData[$cardNumber])){
                $successValue['error'] = 'Card Not Exist';
            }  
            $successValue['card_id'] = (int) array_key_exists($cardNumber, $cardsInImportsData) ?  $cardsInImportsData[$cardNumber] : '';           
            $successData[] = $successValue;
        }

        return  $successData;
    }

    public static function _moduleMethod($fileModule){
        
        $import = '';       
        switch ($fileModule) {
            case "CardSummaryReport":
                $import = new CardImport();
            break; 
            case "fixed-deposit":
                $import = new FixedDepositImport();
            break;           
            default:
                $import = '';
        }

        return $import;
    }
 

}
