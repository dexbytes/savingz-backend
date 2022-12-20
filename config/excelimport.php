<?php

return [
    "import_dealy_time" => env('IMPORT_DEALY_TIME',10),
    "extract_dealy_time" => env('EXTRACT_DEALY_TIME',5),
    'filesystem' => env('EXCEL_FILESYSTEM_DISK','public'),
    'json_upload_path' => env('EXCEL_JSON_UPLOAD_PATH','ExcelImportJson'),
    'remove_json_dealy_time' => env('EXCEL_REMOVE_JSON_DEALY_TIME',1),
];