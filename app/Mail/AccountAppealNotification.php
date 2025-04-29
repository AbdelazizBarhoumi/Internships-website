<?php

namespace App\Mail;

use App\Models\User;
use App\Models\AccountAppeal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountAppealNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public AccountAppeal $appeal
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Account Appeal - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.account-appeal-notification',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'appealReason' => $this->appeal->reason,
                'appealInfo' => $this->appeal->additional_info,
                'appealId' => $this->appeal->id,
                'userType' => $this->user->isEmployer() ? 'Employer' : 'Student',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}