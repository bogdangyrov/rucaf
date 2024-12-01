<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Propaganistas\LaravelPhone\PhoneNumber;

class OneClickOrder extends Mailable
{
    use Queueable, SerializesModels;


    public $name;
    public $phone;
    public $comment;
    public $quantity;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $phone, ?string $comment, ?int $quantity, Product $product)
    {
        $this->name = $name;
        $this->phone = new PhoneNumber($phone, 'RU');;
        $this->comment = $comment;
        $this->quantity = $quantity;
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Заказ на товар',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.one-click-order',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
