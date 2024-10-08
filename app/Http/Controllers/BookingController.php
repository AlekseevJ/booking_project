<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;

class BookingController extends Controller
{
    public function getBooking(BookingService $bookingService): Factory|View
    {
        $bookings = $bookingService->getBookings();

        return view('bookings.index', ['bookings' => $bookings]);
    }

    public function storeBooking(Request $request, BookingService $bookingService): Redirector|RedirectResponse
    {
        $bookingService->setBooking($request->started_at, $request->finished_at, $request->room_id);

        return redirect()->route('bookings.index');
    }

    public function show(Request $request, BookingService $bookingService): Factory|View
    {
        $booking = $bookingService->getBookingById($request->booking);

        return view('bookings.show', ['booking' => $booking]);
    }

    public function bookReject(Request $request, BookingService $bookingService): Redirector|RedirectResponse
    {
        $book = $request->booking;
        $bookingService->rejectBook($book);

        return redirect()->route('bookings.index');
    }
}
