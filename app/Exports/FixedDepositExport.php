<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Storage;
use Maatwebsite\Excel\Concerns\FromArray;
use App\Constants\ExcelImport\CardSummaryHeader;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FixedDepositExport implements FromArray, WithHeadings
{
    public function __construct(array $data,string $file)
    {
        $this->data = $data;
        $this->file = $file;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $data = $this->data;
        $array = array();
        $header = \App\Constants\ExcelImport\FixedDepositHeader::HEADER;
        foreach ($data as $key => $value) {
            $ar = array();
            foreach($header as $key => $val){
                $ar[$key] = isset($value[$key]) ? $value[$key] : "";
            }
            array_push($array,$ar);
        }
        return $array;
    }
    public function headings(): array
    {
        $data = str_replace('_', ' ',array_keys(\App\Constants\ExcelImport\FixedDepositHeader::HEADER));
        for ($i = 0; $i < count($data); $i++) {
            $data[$i] = isset($data[$i]) ? ucwords($data[$i]) : "";
        }
        return $data;
    }
}
