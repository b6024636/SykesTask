<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookings\Bookings;
use App\Models\Locations\Locations;
use App\Models\Properties\Properties;
//use Illuminate\Support\Facades\Request;

class SykesController extends Controller
{
    /**
     * @var Bookings
     */
    private $bookings;
    /**
     * @var Locations
     */
    private $locations;
    /**
     * @var Properties
     */
    private $properties;

    /**
     * SykesController constructor.
     * @param Bookings $bookings
     * @param Locations $locations
     * @param Properties $properties
     */
    public function __construct(Bookings $bookings, Locations $locations, Properties $properties)
    {
        $this->bookings = $bookings;
        $this->locations = $locations;
        $this->properties = $properties;
    }

    public function index()
    {
        $properties = $this->properties::all();
        $locations = $this->locations::all();

        return view('welcome', ['properties' => $properties, 'locations' => $locations]);
    }

    public function search(Request $request)
    {
        $properties = $this->properties->where([
            ['_fk_location', '=', $request->location],
            ['near_beach', '=', isset($request->{'near-beach'}) ? 1 : 0],
            ['accepts_pets', '=', isset($request->{'pets-allowed'}) ? 1 : 0],
            ['sleeps', '>=', $request->sleeps],
            ['beds', '>=', $request->beds]
        ])->get();

        $noResults = false;
        if(count($properties) < 1) {
            $properties = $this->properties->where([
                ['_fk_location', '=', $request->location]
            ])->get();
            $noResults = true;
        }

        return json_encode(['availableProperties' => $properties, 'bookingClashes' => $this->manageBookings($request), 'noResults' => $noResults]);
    }

    public function manageBookings(Request $request)
    {
        $endDate = strtotime('+'.$request->nights.' days', strtotime($request->{'trip-start'}));
        $endDate = date("Y-m-d", $endDate);
        $bookedDates = $this->bookings::select('*')->whereIn(
            '_fk_property',
            $this->properties::select('__pk')->where('_fk_location', $request->location)
        )->get();

        $clash = [];
        foreach ($bookedDates as $date)
        {
            if($request->{'trip-start'} > $date->end_date)
                continue;
            if($endDate < $date->start_date)
                continue;
            $clash[$date->__pk] = [
                'bookingId' => $date->__pk,
                'property' => $date->_fk_property,
                'chosenDates' => [
                    $request->{'trip-start'},
                    $endDate
                ],
                'bookedDates' => [
                    $date->start_date,
                    $date->end_date
                ]
            ];
        }

        return $clash;
    }
}
