<?php

namespace App\Jobs;

use App\Mail\AdminCustomMail;
use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    public $tries = 5;
    public $maxExceptions = 3;
    public $timeout = 43200;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new \Twilio\Rest\Client(config('constant.twilio_sid'), config('constant.twilio_token'));
        $message = $client->messages->create(
            $this->details['phone'], // Text this number
            [
                'from' => '+18888361285', // From a valid Twilio number
                'body' => $this->details['body'],
                'messagingServiceSid'=>config('constant.twilio_mario_service')
            ]
        );
        Message::create([
            'sid'=>$message->sid,
            'recipient'=>$this->details['phone'],
            'body'=>$this->details['body'],
        ]);
    }
}
