<?php

namespace App\Game\Traits;

use Carbon\Carbon;

trait ReleaseDatable
{
    public function getReleaseDate(): String
    {
        if (! isset($this->getParams()["first_release_date"])) {
            return "No date yet";
        }

        return Carbon::parse($this->getParams()["first_release_date"])->format('M d, Y');
    }
}
