<?php

/**
 * Created by PhpStorm.
 * User: Arash-Laptop
 * Date: 06/21/2018
 * Time: 12:48 PM
 */

namespace App\Helpers;


use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class DateUtility
{
    static function convertDigit_persian_english($string)
    {
        $string = str_replace('/', '-', $string);
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);
        return Verta::parse($englishNumbersOnly);
    }

    public static function shamsiTomiladi($date)
    {
        $date = self::convertDigit_persian_english($date);
        $date = Verta::getGregorian($date->year, $date->month, $date->day);
        return Carbon::create($date[0], $date[1], $date[2]);
    }
}
