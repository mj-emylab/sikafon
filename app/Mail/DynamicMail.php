<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DynamicMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $title;
    public $body;
    public $dear;
    public $thanks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $title, $body)
    {
        $dear = 'Hi';
        
        $thanks = "<br>For more information email us at <a href='mailto:info@nana-frimpomaa.com'> info@sikafon.net</a> Or Our Website: <a href='https://sikafon.net/'> sikafon.net</a> <br><br>Follow us on: <a href='https://instagram.com/sikafon?igshid=NTc4MTIwNjQ2YQ=='>Instagram link</a><br><br>Use this link to visit our store for our apps:<a href='http://playstore.com'>Siakafon App</a>";

        $this->dear = $dear;
        $this->thanks = $thanks;
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Sikafon Email")
            ->markdown('mails.dynamic');
    }
}
