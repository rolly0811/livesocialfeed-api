<?php
namespace App\Contracts\Notifications;

interface EmailNotificationInterface
{
    public function send($to, $subject, $body, $from = null, $attachments = []);
}