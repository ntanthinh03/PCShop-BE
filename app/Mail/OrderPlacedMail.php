<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation - '.$this->order->order_code,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "<h1>Order Confirmed!</h1><p>Thank you for your order #{$this->order->order_code}. Total: \${$this->order->total_amount}</p>",
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
