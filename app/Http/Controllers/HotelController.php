<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetHotelRequest;
use App\Services\BookingService;
use App\Services\HotelService;
use App\Services\RequestParserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HotelController extends Controller
{
    public function getHotels(HotelService $hotelService, GetHotelRequest $request, RequestParserService $parser): Factory|View
    {
        $request->has('criteria') ? $criteria = $parser->parseParams($request->get('criteria')) : $criteria = [];
        $request->has('facilities') ? $criteria = $parser->parseParamFacilities($request->get('facilities')) : $facilities = [''];
        $hotels = $hotelService->findBy($criteria, $facilities);

        return view('hotels.index', ['hotels' => $hotels]);
    }

    public function getHotel(HotelService $hotelService, BookingService $bookingService, GetHotelRequest $request): Factory|View
    {
        $startDate = request()->get('start_date', \Carbon\Carbon::now()->format('Y-m-d'));
        $endDate = request()->get('end_date', \Carbon\Carbon::now()->addDay()->format('Y-m-d'));
        $interval = [$startDate, $endDate];
        $hotelRooms = $hotelService->findFreeRooms($request->hotel, $interval);
        $hotelWithPrice = $hotelService->calculatePrice($startDate, $endDate, $hotelRooms);

        return view('hotels.show', ['hotel' => $hotelWithPrice, 'rooms' => $hotelWithPrice->rooms]);
    }
}
