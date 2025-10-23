<?php

if (!function_exists('format_currency')) {
    function format_currency($amount, $currency = 'EGP', $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $formattedNumber = number_format($amount, 2);

        $currencyLabels = [
            'EGP' => [
                'en' => 'EGP',
                'ar' => 'ج.م',
            ],
            'USD' => [
                'en' => 'USD',
                'ar' => 'دولار',
            ],
        ];

        $label = $currencyLabels[$currency][$locale] ?? $currency;
        return $formattedNumber . ' ' . $label;
    }
}
