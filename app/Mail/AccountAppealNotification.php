<?php

namespace App\Mail;

use App\Models\AccountAppeal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountAppealNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $appeal;
    public $userName;
    public $userEmail;
    public $appealReason;
    public $additionalInfo;
    public $appealId;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, AccountAppeal $appeal)
    {
        $this->user = $user;
        $this->appeal = $appeal;
        
        // Set public properties directly
        $this->userName = $user->name;
        $this->userEmail = $user->email;
        $this->appealReason = $appeal->reason;
        $this->additionalInfo = $appeal->additional_info;
        $this->appealId = $appeal->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Account Appeal - ' . $this->userName)
                    ->view('emails.admin.account-appeal-notification');
    }
}