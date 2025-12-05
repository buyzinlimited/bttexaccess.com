<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Mail\LatestProductMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Batchable;

class SendLatestProductMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected $user;
    protected $product;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new LatestProductMail($this->product));
    }
}
