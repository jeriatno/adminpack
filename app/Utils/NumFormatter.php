<?php

namespace App\Utils;

class NumFormatter
{
    public static function toAmount($number)
    {
        return (float)str_replace(',', '', $number);
    }

    public static function toCurrency($amount, $curr = null)
    {
        $decimal = $curr === 'IDR' ? 0 : 2;

        return $curr.' <span style="float:right">'.number_format((float) $amount, $decimal).'</span>';
    }
}
