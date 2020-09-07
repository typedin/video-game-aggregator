<?php

namespace App\Game\Traits;

trait Summarizable
{
    public function getFormattedSummary()
    {
        if (! isset($this->getParams()["summary"])) {
            return "No summary yet";
        }

        return $this->getParams()["summary"];
    }
}
