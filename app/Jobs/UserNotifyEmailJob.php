<?php

namespace App\Jobs;

use App\Mail\UserNotifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserNotifyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    public function handle()
    {
        Mail::to($this->emailData['to'])->send(new UserNotifyEmail($this->emailData));
    }
}
