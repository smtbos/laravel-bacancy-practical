<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductExpiringMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $lots;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $lots)
    {
        $this->user = $user;
        $this->lots = $lots;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Product Expiring',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.product-expiring-mail',
        );
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('mail.product-expiring-mail')
            ->with([
                'user' => $this->user,
                'lots' => $this->lots,
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
