<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    public static function groupByCapitalLetter($cities)
    {
        $citiesGrouped = [];
        foreach ($cities as $city) {
            $capitalLetter = mb_substr($city['name'], 0, 1, 'UTF-8');
            $citiesGrouped[$capitalLetter][] = $city;
        }
        return $citiesGrouped;
    }
}
