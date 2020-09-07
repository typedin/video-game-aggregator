<?php

namespace App\Game\Traits;

trait Summarizable
{
    public function getSummary()
    {
        if (! isset($this->getParams()["summary"])) {
            return "No summary yet";
        }

        return $this->getParams()["summary"];
    }
}
