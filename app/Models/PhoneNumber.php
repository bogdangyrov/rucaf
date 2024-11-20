<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\PhoneNumber as PhoneNumberFormatter;

class PhoneNumber extends Model
{
    public $timestamps = false;

    public function formattedNumber()
    {
        $phone = new PhoneNumberFormatter($this->number, 'RU');
        return $phone->formatNational();
    }

    public function formattedLinkNumber()
    {
        $phone = new PhoneNumberFormatter($this->number, 'RU');
        return $phone->formatE164();
    }
}
