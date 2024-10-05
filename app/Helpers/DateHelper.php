<?php

namespace App\Helpers;
use Carbon\Carbon;
use File;

class DateHelper
{

    private function __construct()
    {
    }

    public static function getInstance()
    {
        return new self();
    }


    /**
     * @param $endDate
     * @return int
     */
    public function checkExpire($endDate){
        return $endDate <= Carbon::now()->toDateString() ? 1 : 0;
    }

    /**
     * @param $date
     * @return false|string
     */
    function customDateFormat($date)
    {
        return $date ? date('d/m/Y', strtotime($date)) : null;
    }

    /**
     * @param $date
     * @return false|string|null
     */
    function customDateFormatWithTime($date)
    {
        return $date ? date('d/m/Y H:i a', strtotime($date)) : null;
    }
}
