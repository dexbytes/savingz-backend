<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Bank\CardTransaction;
use App\Models\Import\ExcelImport;
use App\Constants\ExcelImport\ExcelStatus;

class CardSummaryExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $request;
  
    /**
     * Create a new job instance.
     *
     * @return void
     */
   public function __construct($request)
    {
        $this->request  = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data =  CardTransaction::CardSummaryUpload($this->request);
        $this->delete();
    }


    public function failed(\Exception $e = null)
    {
        ExcelImport::where('id', $this->request)->update(['status' => ExcelStatus::FAILED]);
        $this->delete();
    }
}