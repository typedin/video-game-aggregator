<?php

namespace Tests;

trait BadDataCapable
{
    private function makeBadData($data)
    {
        $badDataForAGame = [
            "no-name" => "no-name",
            "no-slug" => "no-slug"
        ];

        array_push($data, $badDataForAGame);
        return $data;
    }
}
