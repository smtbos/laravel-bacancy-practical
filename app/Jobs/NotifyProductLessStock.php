<?php

namespace App\Jobs;

use App\Mail\ProductLessStockMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyProductLessStock implements ShouldQueue
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

        /* Products with less stock */
        $products = $user->products()
            ->lessStock()
            ->get();

        if ($products->isNotEmpty()) {
            Mail::to($user->email)->send(new ProductLessStockMail($user, $products));
        }
    }
}
