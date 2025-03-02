<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use this command for cron jobs if you are trying to send custom bulk sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->call('queue:work', [
            '--stop-when-empty' => 1,
        ]);
    }
}
