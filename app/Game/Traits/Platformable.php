<?php

namespace App\Game\Traits;

trait Platformable
{
    public function getFormattedPlatforms()
    {
        return collect($this->getParams()["platforms"])->pluck("abbreviation")->filter()->join(", ");
    }
}
