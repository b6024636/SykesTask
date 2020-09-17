<?php


namespace App\Models\Properties;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    protected $fillable = [
        '__pk',
        '_fk_location',
        'property_name',
        'near_beach',
        'accepts_pets',
        'sleeps',
        'beds'
    ];
}