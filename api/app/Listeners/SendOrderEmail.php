<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail
{
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        Mail::to($order->customer->email)->send(new OrderCreatedMail($order));
    }
}
