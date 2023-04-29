<?php

namespace App\Mail;

use App\BookingDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelRefundMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BookingDetail $booking, $request)
    {
        $this->booking = $booking;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->view('admin.templates.cancel_refund')->with([
            'name'                      => $this->booking->user->name,
            'razorpay_payment_id'       => $this->booking->payment_id,
            'refund_date'               => date('d-M-Y', strtotime($this->request)),
            'amount'               => $this->booking->amount,
        ]);
    }
}
