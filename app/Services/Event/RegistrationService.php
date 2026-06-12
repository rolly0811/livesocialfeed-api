<?php

namespace App\Services\Event;

use App\Models\EventRegisteredUser;
use App\Services\EmailNotification\EmailNotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegistrationService
{
    protected $emailService;

    public function __construct(EmailNotificationService $emailService) {
        $this->emailService = $emailService;
    }

    public function sendMailNotification($registration) {
        $link = config('app.api_baseurl') . '/event-registration/' . $registration->registration_code;
        $to = $registration->user->email;
        $subject = 'Passport-to-IDo: Registration Successful';
        $body = view('mail.registration', ['name' => $registration->user->name, 'link' => $link])->render();
        $from = 'noreply@livesocialfeed.com';
        $emailResponse = $this->emailService->sendMail($to, $subject, $body, $from);

        Log::info('Registration Email Sent', $emailResponse);

        return $emailResponse;
    }
    public function register($data) {
        $code = Str::random(28);
        $registeredUser = EventRegisteredUser::firstOrCreate(
            ['email' => $data->email],
            [
                'email' => $data->email,
                'name' => $data->name,
                'mobile' => $data->mobile,
                'city' => $data->city,
                'social' => $data->socialMedia,
                'status' => 'active',
                'password' => bcrypt(Str::random(16)), // Generate a random password
            ]
        );

        $registration = $registeredUser->registrations()->create([
            'code' => $code,
            'category_id' => $data->category,
            'partner_name' => $data->partner_name,
            'registered_as' => $data->registering_as,
            'details' => json_encode($data->event),
            'source' => $data->source,
            'biggest_challenge' => $data->biggest_challenge,
            'preferred_style' => $data->style,
            'receive_updates' => $data->receive_updates,
            'agreed_policy' => $data->agreed,
            'registration_code' => $code,
        ]);

        $registration->update([
            'live_id' => date('Ymd', strtotime($registration->created_at)) . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT)
        ]);

        $this->sendMailNotification($registration);
        
        return $registeredUser;
    }

}