<?php

namespace App\Imports;

use App\Models\ExcelImport\ExcelImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use App\Constants\ExcelImport\ExcelStatus;
use Carbon\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Constants\ExcelImport\FixedDepositHeader;


class FixedDepositImport implements ToModel,SkipsEmptyRows, WithHeadingRow, WithValidation,SkipsOnError,SkipsOnFailure,WithEvents
{
    use Importable,SkipsErrors,SkipsFailures,RegistersEventListeners;

    private $rows = array();
    private static  $array = array();


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rows[] = $row;
    }


    public function rules(): array
    {
        return FixedDepositHeader::HEADER;
    }


    public function get(): array
    {
        return $this->rows;
    }


    public static function beforeImport(BeforeImport $event)
    {
        static::$array['beforeImport'] = [
            'status' => ExcelStatus::IN_PROGRESS,
            'extract_start_date' => Carbon::now(),
        ];
    }
	
    public static function afterImport(AfterImport $event)
    {
        static::$array['afterImport'] = [
            'status' => ExcelStatus::WAITING_APPROVAL,
            'extract_end_date' => Carbon::now(),
        ];
    }

    
    public function process(): array
    {
        return static::$array;
    }
}
