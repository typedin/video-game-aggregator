<?php

namespace App\Game\Exceptions;

use InvalidArgumentException;

class GameException extends \InvalidArgumentException
{
    public static function noName()
    {
        return new self("Trying to instanciate a game without a name");
    }

    public static function noSlug()
    {
        return new self("Trying to instanciate a game without a slug");
    }
}
