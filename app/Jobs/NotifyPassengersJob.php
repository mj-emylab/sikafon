<?php

namespace App\Jobs;

use App\Helpers\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyPassengersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $booking;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        if (count($this->booking->passengers) > 0) {

            foreach ($this->booking->passengers as $passenger) {

                $name = $passenger['first_name'] . ' ' . $passenger['last_name'];

                $from = $this->booking->trip->from->name;
                $to = $this->booking->trip->to->name;
                $pickUpPoint = $passenger->pickUpPoint->name;
                $pnr = $this->booking->pnr;

                $message = "Hello $name, trip from $from to $to has  is $pickUpPoint\nYou can login with code:  $pnr and surname : ".$passenger['last_name']. " to view your booking details.";

                try {
                    Helper::sendSms($passenger['phone_number'], $message);
                }catch (\Exception $e) {
                    logger("error sending sms: ".$e->getMessage());
                }
            }





        }
    }
}
