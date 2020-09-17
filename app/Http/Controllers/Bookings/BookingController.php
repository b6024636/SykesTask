<?php


namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookings\Bookings;

class BookingController extends Controller
{
    /**
     * @var \App\Models\Bookings\Bookings
     */
    private $bookings;

    /**
     * BookingController constructor.
     * @param \App\Models\Bookings\Bookings $bookings
     */
    public function __construct(Bookings $bookings)
    {
        $this->bookings = $bookings;
    }

    public function index()
    {
        $bookings = $this->bookings::all();

        return view('bookingstest', ['bookings' => $bookings]);
    }
}