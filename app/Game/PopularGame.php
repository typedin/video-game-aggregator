<?php

namespace App\Game;

use App\Game\Traits\Platformable;
use App\Game\Traits\Rateable;
use App\Game\Traits\Coverable;
use App\Game\Traits\ReleaseDatable;

class PopularGame extends AbstractGame
{
    use Coverable, ReleaseDatable, Rateable, Platformable;
}
