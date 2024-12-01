<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Propaganistas\LaravelPhone\PhoneNumber;

class RequestPrice extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phone;
    public $comment;
    public $quantity;
    public $product;
    public $city;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $phone, ?string $comment, ?int $quantity, Product $product, ?string $city)
    {
        $this->name = $name;
        $this->phone = new PhoneNumber($phone, 'RU');;
        $this->comment = $comment;
        $this->quantity = $quantity;
        $this->product = $product;
        $this->city = $city;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Запрос на стоимость',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.request-price',
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
