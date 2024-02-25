<?php

namespace App\Jobs;

use App\Models\ProductLot;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckProductExpiring implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $userIds = ProductLot::select('user_id')
            ->expiringInNextDays()
            ->groupBy('user_id')
            ->pluck('user_id');

        foreach ($userIds as $userId) {
            NotifyProductExpiring::dispatch($userId);
        }
    }
}
