<?php

namespace App\Game\Traits;

trait Genreable
{
    public function getFormattedGenres()
    {
        return collect($this->getParams()["genres"])
            ->pluck("name")
            ->filter()->join(", ");
    }
}
