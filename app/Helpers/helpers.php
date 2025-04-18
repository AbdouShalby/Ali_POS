<?php

if (!function_exists('format_currency')) {
    /**
     * Format a number as currency
     *
     * @param float|null $amount
     * @param string $currency
     * @return string
     */
    function format_currency($amount, $currency = 'SAR')
    {
        if ($amount === null) {
            return $currency . ' 0.00';
        }
        
        return $currency . ' ' . number_format((float) $amount, 2, '.', ',');
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    function format_date($date, $format = 'Y-m-d')
    {
        if (!$date) {
            return __('customers.not_available');
        }
        
        return date($format, strtotime($date));
    }
} 