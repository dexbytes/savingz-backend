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
use Storage;

class ExcelExport extends Model
{
    public static function ExcelExtract($file)
    {
       try{
           $payload = array();          
           if (empty(Storage::disk(config('excelimport.filesystem'))->exists($file->path))) {
               $payload['error_log'] = 'no file found';
               $payload['status'] = ExcelStatus::FAILED;
               ExcelImport::where('id',$request->id)->update($payload);
               return true;
           }

            $payload['status'] = ExcelStatus::IN_PROGRESS;
            $path = Storage::disk(config('excelimport.filesystem'))->path($file->path);
            $import = new CardImport();
            $import->import($path);

            $error = array();
            foreach ($import->failures() as $failure) {
                $error[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'values' => $failure->values(),
                ];
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

    public static function CardSummaryUpload($request)
    {
        $time_start = microtime(true);
        $file = ExcelImport::where('id',$request)->first();
        $record =  @json_decode(Storage::disk(config('excelimport.filesystem'))->get($file->success_path),true);
        return true;
    }

}
