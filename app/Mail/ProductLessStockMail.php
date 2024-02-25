<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductLessStockMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $products;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $products)
    {
        $this->user = $user;
        $this->products = $products;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Product Less Stock',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.product-less-stock-mail',
        );
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('mail.product-less-stock-mail', [
            'user' => $this->user,
            'products' => $this->products,
        ]);
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
