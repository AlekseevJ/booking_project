<?php

namespace App\Services;

use App\Events\BookProcessed;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function setBooking(string $start_date, string $end_date, int $room_id): void
    {
        $id = Auth::user()->id;
        $days = \Carbon\Carbon::parse($end_date)->diffInDays(\Carbon\Carbon::parse($start_date));

        $price = Room::find($room_id)->price * $days;

        $book = Booking::create([
            'room_id' => $room_id,
            'user_id' => $id,
            'started_at' => $start_date,
            'finished_at' => $end_date,
            'days' => $days,
            'price' => $price,
        ]);

        BookProcessed::dispatch($book, Auth::user());
    }

    public function getBookings(): Collection
    {
        $id = Auth::user()->id;

        return Booking::where('user_id', $id)->where('accepted', true)->get();
    }

    public function getBookingById(int $bookingId): Model
    {
        return Booking::find($bookingId);
    }

    public function acceptBook(): void
    {
        $userId = Auth::user()->id;
        $booking = Booking::find(DB::table('user_mail_accept')->where('user_id', $userId)->select('booking_id')->get()->shift()->booking_id);
        $booking->accepted = true;
        $booking->save();
        DB::table('user_mail_accept')->where('booking_id', $booking->id)->delete();
    }

    public function rejectBook(int $booking): void
    {
        $userId = Auth::user()->id;
        Booking::where('id', $booking)->where('user_id', $userId)->delete();
    }
}