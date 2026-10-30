<?php

namespace App\Helpers;

class CurrencyHelper
{
    protected static $rates = [
        'LKR' => 1,
        'USD' => 0.0033, // 1 LKR = 0.0033 USD
        'EUR' => 0.0031, // 1 LKR = 0.0031 EUR
        'CAD' => 0.0045, // 1 LKR = 0.0045 CAD
        'INR' => 0.28,   // 1 LKR = 0.28 INR
    ];

    protected static $symbols = [
        'LKR' => 'Rs',
        'USD' => '$',
        'EUR' => '€',
        'CAD' => 'C$',
        'INR' => '₹',
    ];

    public static function convert($amount, $to = null)
    {
        $to = $to ?? session('currency', 'LKR');
        $rate = self::$rates[$to] ?? 1;
        
        return $amount * $rate;
    }

    public static function format($amount, $currency = null)
    {
        $currency = $currency ?? session('currency', 'LKR');
        $converted = self::convert($amount, $currency);
        $symbol = self::$symbols[$currency] ?? 'Rs';

        if ($currency === 'LKR') {
            return $symbol . ' ' . number_format($converted, 0, '.', ',');
        }

        return $symbol . ' ' . number_format($converted, 2, '.', ',');
    }

    public static function getCurrencySymbol($currency = null)
    {
        $currency = $currency ?? session('currency', 'LKR');
        return self::$symbols[$currency] ?? 'Rs';
    }
}
