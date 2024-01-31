<?php


if (! function_exists('get_weekday')) {
    /**
     * Get the weekday.
     * @param int $weekday_number
     * @return string
     */
    function get_weekday($weekday_number)
    {
        if ($weekday_number == null) {
            return null;
        }

        $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return $weekdays[$weekday_number - 1];
    }
}
