<?php
namespace App\Services\EmailNotification\Providers;

use App\Contracts\Notifications\EmailNotificationInterface;
use Illuminate\Support\Facades\Http;

class TurboSmtpProvider implements EmailNotificationInterface 
{
    public function send($to, $subject, $body, $from = 'noreply@livesocialfeed.com', $attachments = []) {
        $consumerKey = config('services.turbosmtp.consumerKey');
        $consumerSecret =  config('services.turbosmtp.consumerSecret');

		// $data = [
		// 	"from" => $from,
        //     "to" => $to,
        //     "subject" => $subject,
        //     "html_content" => $body,
        //     "content" => $body
		// ];

		// $ch = curl_init('https://api.turbo-smtp.com/api/v2/mail/send');

		// curl_setopt($ch, CURLOPT_HTTPHEADER, [
		// 	"Content-Type: application/json",
		// 	"consumerKey: $consumerKey",
		// 	"consumerSecret: $consumerSecret",
		// ]);
		// curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// // Execute cURL request
		// $response = curl_exec($ch);

		// // Close cURL session
		// curl_close($ch);

		// return $response;

		$url = 'https://api.turbo-smtp.com/api/v2/mail/send';
		$data = [
			"from" => $from,
            "to" => $to,
            "subject" => $subject,
            "html_content" => $body,
            "content" => $body
		];
		$response = Http::withHeaders(
			[
				'ContentType' => 'application/json',
				'Accept' => 'application/json',
				'consumerKey' => $consumerKey,
				'consumerSecret' => $consumerSecret
			]
		)->post($url, $data);

		return $response->json();
    }
}