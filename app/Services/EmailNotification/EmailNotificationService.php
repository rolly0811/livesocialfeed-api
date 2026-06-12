<?php
namespace App\Services\EmailNotification;

use App\Contracts\Notifications\EmailNotificationInterface;

class EmailNotificationService
{
    protected $mailInterface;
    public function __construct(EmailNotificationInterface $mailInterface) {
        $this->mailInterface = $mailInterface;
    }

    public function sendMail($to, $subject, $body, $from, $attachments = []) {
        return $this->mailInterface->send($to, $subject, $body, $from, $attachments);
    }
}