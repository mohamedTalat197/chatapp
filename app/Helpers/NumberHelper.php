<?php

namespace App\Helpers;

class NumberHelper
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function generateCode() {
        return 111111;
    }

    /**
     * @param $totalPrice
     * @param $discount
     * @param null $discountType
     * @return float|int
     */
    function calculatePercentage($totalPrice, $discount,$discountType = null)
    {
            if($discountType==1)
                return  $discount;
            return $totalPrice * $discount / 100;
    }

    /**
     * @param $totalPrice
     * @param $discount
     * @param null $discountType
     * @return float|int
     */
    function calculateTaxPercentage($totalPrice, $tax,$taxType = null)
    {
            if($taxType==1)
                return  $tax;
            return $totalPrice * $tax / 100;
    }


    public static function dispose()
    {
        self::$instance = null;
    }
}
