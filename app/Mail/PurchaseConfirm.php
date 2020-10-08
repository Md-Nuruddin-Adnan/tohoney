<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order_infos = '';
    public $order_detail_infos = '';

    public function __construct($orders, $order_details)
    {
        $this->order_infos = $orders;
        $this->order_detail_infos = $order_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.purchaseconfirm', [
            'orders' => $this->order_infos,
            'order_details' => $this->order_detail_infos,
        ]);
    }
}
