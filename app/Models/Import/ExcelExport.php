<?php

namespace App\Models\Import;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\ImportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CardImport;
use App\Exports\UsersExport;
use Storage;
use App\Constants\ExcelStatus;
use App\Models\ExcelImport\ExcelImport;

class ExcelExport extends Model
{
    public static function ExcelExtract($file)
    {
       try{
           $array = array();
           $path = Storage::disk(config('excelsettings.filesystem'))->path($file->path);
           if (empty(Storage::disk(config('excelsettings.filesystem'))->exists($file->path))) {
               $array['error_log'] = 'no file found';
               $array['status'] = ExcelStatus::FAILED;
               ExcelImport::where('id',$request->id)->update($array);
               return true;
           }
           $array['status'] = ExcelStatus::IN_PROGRESS;
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
           $error_json = Storage::disk(config('excelsettings.filesystem'))->exists(config('excelsettings.json_upload_path').'/'.$file->id.'/error.json') ? json_decode(Storage::disk(config('excelsettings.filesystem'))->get(config('excelsettings.json_upload_path').'/'.$file->id.'/error.json')) : [];
           $error_file_path = config('excelsettings.json_upload_path').'/'.$file->id.'/error.json';
           Storage::disk(config('excelsettings.filesystem'))->put($error_file_path, json_encode($error,JSON_PRETTY_PRINT));

            //Store Json success data
           $success_json = Storage::disk(config('excelsettings.filesystem'))->exists(config('excelsettings.json_upload_path').'/'.$file->id.'/success.json') ? json_decode(Storage::disk(config('excelsettings.filesystem'))->get(config('excelsettings.json_upload_path').'/'.$file->id.'/success.json')) : [];
           $success_file_path = config('excelsettings.json_upload_path').'/'.$file->id.'/success.json';
           Storage::disk(config('excelsettings.filesystem'))->put($success_file_path, json_encode($import->get(),JSON_PRETTY_PRINT));
           /*----------------------------------------*/

           $process = $import->process(); 
           $array['extract_start_date'] = $process['beforeImport']['extract_start_date'];
           $array['extract_end_date'] = $process['afterImport']['extract_end_date'];
           $array['status'] = isset($process['afterImport']['status']) ? $process['afterImport']['status'] : $process['beforeImport']['status'];
           $array['error_log'] = @json_encode($import->errors());
           $array['failed_path'] = $error_file_path;
           $array['success_path'] = $success_file_path;
           ExcelImport::where('id',$file->id)->update($array);
           return $array;
       } catch ( ValidationException $e) {
           return $e;
       }    
       return $array;
       return true;
    }   

    public static function CardSummaryUpload($request)
    {
        $time_start = microtime(true);
        $file = ExcelImport::where('id',$request)->first();
        $record =  @json_decode(Storage::disk(config('excelsettings.filesystem'))->get($file->success_path),true);
        \Log::info($record);
        \Log::info('start - '. $time_start);
        \Log::info('end  - '. microtime(true));
        return true;
    }

}
