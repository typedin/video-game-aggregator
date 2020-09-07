<?php

namespace App\Game\Traits;

use App\Rating;

trait Rateable
{
    public function getFormatedRating($key): String
    {
        if (! isset($this->getParams()[$key])) {
            return Rating::fromEmpty();
        }

        return Rating::toString($this->getParams()[$key]);
    }
}
