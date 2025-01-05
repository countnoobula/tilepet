<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FunctionDispatcher;
use Illuminate\Support\Facades\Log;

class ProcessActionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $functionCall;

    /**
     * Create a new job instance.
     *
     * @param array $functionCall
     * @return void
     */
    public function __construct(array $functionCall)
    {
        $this->functionCall = $functionCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            FunctionDispatcher::dispatchFunction($this->functionCall);
        } catch (\Exception $e) {
            Log::error('ProcessActionJob Exception: ' . $e->getMessage());
            // Optionally, rethrow the exception to allow the job to be retried
            throw $e;
        }
    }
}
