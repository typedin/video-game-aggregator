<?php

namespace App\Game\Traits;

trait Platformable
{
    public function getPlatforms()
    {
        return collect($this->getParams()["platforms"])->pluck("abbreviation")->filter()->join(", ");
    }
}
