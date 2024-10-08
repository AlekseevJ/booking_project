<?php

namespace App\Services;

use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HotelService
{
    public function findBy(array $criteria = [], array $facilities = [''], array $sort = ['id', 'asc'], int $limit = 20): Collection
    {
        return Hotel::select(
            'hotels.id',
            'hotels.title',
            'hotels.description',
            'hotels.poster_url',
            'hotels.address',
            \DB::raw('MIN(rooms.price) as price'),
            \DB::raw("STRING_AGG(facilities.title, ', ') as include_facilities"),
            'hotels.created_at',
            'hotels.updated_at'
        )
            ->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('facility_hotels', 'hotels.id', '=', 'facility_hotels.hotel_id')
            ->join('facilities', 'facilities.id', '=', 'facility_hotels.facility_id')
            ->groupBy('hotels.id')
            ->havingRaw("STRING_AGG(facilities.title, ', ') ILIKE ?", ['%' . implode('%', $facilities) . '%'])
            ->where($criteria)
            ->orderBy($sort[0], $sort[1])
            ->limit($limit)
            ->get();
    }

    public function calculatePrice(string $startDate, string $endDate, Model $hotel): Model
    {
        foreach ($hotel->rooms as $room) {
            $room->total_days = Carbon::parse($endDate)->diffInDays(Carbon::parse($startDate));
            $room->total_price = $room->total_days * $room->price;
        }

        return $hotel;
    }

    public function findFreeRooms(int $hotelId, array $interval = []): Model
    {
        $hotel = Hotel::with([
            'rooms' => function ($query) use ($interval) {
                $query->whereNotExists(function ($subQuery) use ($interval) {
                    $subQuery->select(DB::raw(1))
                        ->from('bookings')
                        ->whereColumn('rooms.id', 'bookings.room_id')
                        ->where(function ($innerQuery) use ($interval) {
                            $innerQuery->whereBetween('started_at', [$interval[0], $interval[1]])
                                ->orWhereBetween('finished_at', [$interval[0], $interval[1]]);
                        });
                });
            }
        ])->find($hotelId);

        return $hotel;
    }
}