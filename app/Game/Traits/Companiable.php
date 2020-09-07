<?php

namespace App\Game\Traits;

trait Companiable
{
    public function getFormattedCompanies()
    {
        return collect($this->getParams()["involved_companies"])
            ->pluck("company.name")
            ->filter()->join(", ");
    }
}
