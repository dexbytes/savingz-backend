<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Import\ExcelExport as ExcelExportModel;

class ExtractExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $request;
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
        \Log::info($this->request);
        $data =  ExcelExportModel::ExcelExtract((object) $this->request);
        $this->delete();
    }
    
    /**
     * Failed the job.
     *
     * @return void
     */
    public function failed(\Exception $e = null)
    {
        \Log::Error($this->request);
        $this->delete();
    }

}
