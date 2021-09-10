<?php

namespace App\Helpers;

class ArabicToEnglishConverter
{
    public static function convert($string) {
        // $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨','٩'];
        
        if(preg_match('/[\x{0621}-\x{064A}\x{0660}-\x{0669}]/u', $string, $matches) !== false){
            // [\u0621-\u064A\u0660-\u0669]
            // [\x{0590}-\x{05fe} ]
            $num = range(0, 9);
            // $convertedPersianNums = str_replace($persian, $num, $string);
            $englishNumbersOnly = str_replace($arabic, $num, $string);

            return $englishNumbersOnly;
        }
        return $string;
    }
}