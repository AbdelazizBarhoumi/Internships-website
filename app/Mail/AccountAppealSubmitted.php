<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountAppealSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $appealReason;
    public ?string $additionalInfo;
    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(
        User $user, 
        string $appealReason, 
        ?string $additionalInfo = null
    ) {
        $this->user = $user;
        $this->appealReason = $appealReason;
        $this->additionalInfo = $additionalInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Account Appeal Submitted - ' . config('app.name'))
            ->view('emails.account-appeal-submitted');
    }
}