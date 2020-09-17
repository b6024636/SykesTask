<?php


namespace App\Models\Bookings;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $fillable = [
        '__pk',
        '_fk_property',
        'start_date',
        'end_date'
    ];
}