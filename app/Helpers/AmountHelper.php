<?php

if (!function_exists('amountInWords')) {
    function amountInWords($amount)
    {
        $amount = number_format((float) $amount, 2, '.', '');

        [$taka, $poisha] = explode('.', $amount);

        $takaWords = numberToWords((int) $taka);

        $result = $takaWords . ' Taka';

        if ((int) $poisha > 0) {
            $result .= ' and ' . numberToWords((int) $poisha) . ' Poisha';
        }

        return $result . ' Only';
    }
}

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $ones = [
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Thirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eighteen',
            'Nineteen'
        ];

        $tens = [
            '',
            '',
            'Twenty',
            'Thirty',
            'Forty',
            'Fifty',
            'Sixty',
            'Seventy',
            'Eighty',
            'Ninety'
        ];

        if ($number < 20) {
            return $ones[$number];
        }

        if ($number < 100) {
            return $tens[intdiv($number, 10)] .
                (($number % 10) ? ' ' . $ones[$number % 10] : '');
        }

        if ($number < 1000) {
            return $ones[intdiv($number, 100)] . ' Hundred' .
                (($number % 100) ? ' ' . numberToWords($number % 100) : '');
        }

        if ($number < 100000) {
            return numberToWords(intdiv($number, 1000)) . ' Thousand' .
                (($number % 1000) ? ' ' . numberToWords($number % 1000) : '');
        }

        if ($number < 10000000) {
            return numberToWords(intdiv($number, 100000)) . ' Lakh' .
                (($number % 100000) ? ' ' . numberToWords($number % 100000) : '');
        }

        return numberToWords(intdiv($number, 10000000)) . ' Crore' .
            (($number % 10000000) ? ' ' . numberToWords($number % 10000000) : '');
    }
}
