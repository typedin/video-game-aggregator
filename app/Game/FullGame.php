<?php

namespace App\Game;

use App\Game\AbstractGame;
use App\Game\Traits\Companiable;
use App\Game\Traits\Coverable;
use App\Game\Traits\Genreable;
use App\Game\Traits\Platformable;
use App\Game\Traits\Rateable;
use App\Game\Traits\ReleaseDatable;
use App\Game\Traits\Summarizable;

/**
 * Class Game
 * @author typedin
 */
class FullGame extends AbstractGame
{
    use Companiable,
        Coverable,
        Genreable,
        Platformable,
        Rateable,
        ReleaseDatable,
        Summarizable;
}
