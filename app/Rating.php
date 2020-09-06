<?php

namespace App;

/**
 * Class Rating
 * @author yourname
 */
class Rating
{
    public static function toString($rating): String
    {
        return round($rating)."%";
    }

    public static function fromEmpty(): String
    {
        return "N/A";
    }
}
