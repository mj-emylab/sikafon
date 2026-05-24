<?php

namespace App\Jobs;

use App\Mail\DynamicMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class DynamicMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $title;
    private $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $title, $body)
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if($this->user->email)
            {
                Mail::to($this->user->email)
                    ->send(new DynamicMail($this->user, $this->title, $this->body));
            }
        }catch (\Exception $e)
        {
            logger("error sending email: ".$e->getMessage());
        }

    }
}
