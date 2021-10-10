<?php

if (!function_exists("date_to_cal")) {
    function datetime_to_cal($datetime) {
        return \Carbon\Carbon::parse($datetime)->format('Ymd\This').'Z';
    }
}
