<?php

namespace App\Providers;

use App\View\Components\Bookings\BookingCard;
use App\View\Components\Dropdown;
use App\View\Components\DropdownLink;
use App\View\Layouts\App;
use App\View\Layouts\Guest;
use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('app-layout', App::class);
        Blade::component('guest-layout', Guest::class);
        Blade::component('booking-card', BookingCard::class);
    }
}
