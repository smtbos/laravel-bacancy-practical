<?php

namespace App\Jobs;

use App\Mail\ProductExpiringMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyProductExpiring implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);

        /* Lots expiring in next 10 days */
        $lots = $user->lots()
            ->expiringInNextDays()
            ->with('product')
            ->get();
        Log::info('NotifyProductExpiring: ' . $lots->count() . ' lots expiring in next 10 days');
        if ($lots->isNotEmpty()) {
            Mail::to($user->email)->send(new ProductExpiringMail($user, $lots));
        }
    }
}
