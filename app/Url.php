<?php

namespace App;

use InvalidArgumentException;

/**
 * Class Url
 * @author yourname
 */
class Url
{
    public $value;
    
    public function __construct(string $string)
    {
        if (! filter_var($string, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException();
        }
        $this->value = $string;
    }
}
