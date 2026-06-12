<?php

namespace Tests\Feature;

use App\Services\EmailNotification\EmailNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailNotificationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEmail()
    {   
        $emailService = app(\App\Services\EmailNotification\EmailNotificationService::class);
        $to = 'domingorolly11@gmail.com';
        $subject = 'Test Mail';
        $body = '<h1>Test Body</h1>';
        $from = 'noreply@livesocialfeed.com';
        $response = $emailService->sendMail($to, $subject, $body, $from);

        dd($response);
    }
}
