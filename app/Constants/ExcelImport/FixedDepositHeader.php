<?php

namespace App\Constants\ExcelImport;

class FixedDepositHeader
{
    const HEADER = [  
        'allotment_date' => 'required',
        'investor' => 'required',
        'entity' => 'required',
        'pan' => 'required',
        'fd_issuer' => 'nullable',
        'tenure_months' => 'required',
        'tenure_days' => 'required',
        'amount' => 'required',
        'interest_rate' => 'required',
        'type' => 'required',
        'commission_in_rate' => 'nullable',
        'commission_out_rate' => 'nullable',
        'reference_number' => 'required',
        'bank_name' => 'required',
        'cheque_number' => 'nullable',
        'remarks' => 'nullable ',
    ];
}
