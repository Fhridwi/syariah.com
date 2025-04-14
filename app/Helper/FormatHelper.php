<?php

namespace App\Helpers;

class FormatHelper
{
    public static function terbilang($angka)
    {
        $formatter = new \NumberFormatter("id", \NumberFormatter::SPELLOUT);
        return ucwords($formatter->format($angka));
    }

    
}
