<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class MailController extends Controller
{
    public function acceptBookEmail(Request $request, MailService $mailService, BookingService $bookingService): Redirector|RedirectResponse
    {

        if ($mailService->compareToken($request->token)) {
            $bookingService->acceptBook();
        }

        return redirect()->route('bookings.index');
    }
}
