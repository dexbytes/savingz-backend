<?php

namespace App\Constants\ExcelImport;

class CardSummaryHeader
{
    const HEADER = [
        'txn_date' => 'required|date_format:d/m/Y H:i:s',
        'card_number' => 'required|numeric',
        'txn_amt' => 'required',
        'txn_type' => 'required|string',
        'available_balance' => 'required',
        'ledger_balance' => 'required',
        'status' => 'required',
    ];
}
