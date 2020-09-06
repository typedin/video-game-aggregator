<?php

namespace App\Contracts;

interface Game
{
    public function getName(): String;

    public function getSlug(): String;

    public function getParams(): array;
}
