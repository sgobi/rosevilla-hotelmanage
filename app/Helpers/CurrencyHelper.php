<?php

namespace App\Helpers;

class CurrencyHelper
{
    protected static $symbols = [
        'LKR' => 'Rs.',
        'USD' => '$',
    ];

    /**
     * Get the active currency from session or cookie, defaulting to LKR.
     */
    public static function getCurrentCurrency(): string
    {
        $currency = session('currency');
        if (!$currency && request()) {
            $currency = request()->cookie('currency');
        }
        $currency = strtoupper((string)$currency);
        if (!in_array($currency, ['LKR', 'USD'])) {
            $currency = 'LKR';
        }
        return $currency;
    }

    /**
     * Get the configured conversion exchange rate (LKR per 1 USD).
     */
    public static function getUsdRate(): float
    {
        $rate = (float) config('rosevilla.usd_rate', 310.0);
        return $rate > 0 ? $rate : 310.0;
    }

    /**
     * Convert an LKR base amount into the target currency.
     * USD prices are rounded to the nearest whole dollar.
     */
    public static function convert($amount, $to = null)
    {
        $to = $to ?? self::getCurrentCurrency();
        if ($to === 'USD') {
            return round((float)$amount / self::getUsdRate());
        }
        return (float)$amount;
    }

    /**
     * Format a price according to currency conventions.
     * LKR: "LKR 8,000" or "LKR 8,000 / night"
     * USD: "$26" or "$26 / night"
     */
    public static function format($amount, $currency = null, $withUnit = '')
    {
        $currency = $currency ?? self::getCurrentCurrency();
        if ($currency === 'USD') {
            $val = round((float)$amount / self::getUsdRate());
            return '$' . number_format($val, 0) . ($withUnit ? ' / ' . $withUnit : '');
        }

        return 'LKR ' . number_format((float)$amount, 0) . ($withUnit ? ' / ' . $withUnit : '');
    }

    /**
     * Get the currency symbol.
     */
    public static function getCurrencySymbol($currency = null): string
    {
        $currency = $currency ?? self::getCurrentCurrency();
        return self::$symbols[$currency] ?? 'Rs.';
    }
}
