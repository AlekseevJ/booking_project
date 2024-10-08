<?php

namespace App\View\Components\Bookings;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookingCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public $booking,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bookings.booking-card');
    }
}
