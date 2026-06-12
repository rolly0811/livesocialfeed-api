<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreRegistrationRequest;
use App\Models\EventRegistration;
use App\Services\Event\RegistrationService;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;


class EventRegistrationController extends Controller
{
    protected $registrationService;

    public function __construct(RegistrationService $registrationService) {
        $this->registrationService = $registrationService;
        // You can apply middleware here if needed
    }

    public function register(StoreRegistrationRequest $request) {
        $registration = $this->registrationService->register($request);

        return response()->json(['message' => 'Event registration successful', 'data' => $registration], 201);
    }

    public function details($code) {
        $registration = EventRegistration::where('registration_code', $code)->firstOrFail();
        return response()->json($registration);
    }
    
    public function generateQRCode(Request $request) {
        $qr = new QrCode();
        $qr->setText($request->link)
        ->setSize(300);

        return response($qr->writeString())
            ->header('Content-Type', 'image/png');
    }

    public function attendanceDetails($code) {
        $registration = EventRegistration::with('user')->where('registration_code', $code)->firstOrFail();

        return response()->json($registration);
    }

    public function attendanceConfirm($code) {
        $registration = EventRegistration::where('registration_code', $code)->firstOrFail();
        $registration->update([
            'attended_at' => date('Y-m-d H:i:s')
        ]);

        $registration->load('user');

        return response()->json($registration);
    }
}
