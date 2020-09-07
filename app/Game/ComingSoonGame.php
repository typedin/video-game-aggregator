<?php

namespace App\Game;

use App\Game\Traits\Coverable;
use App\Game\Traits\ReleaseDatable;

final class ComingSoonGame extends AbstractGame
{
    use ReleaseDatable, Coverable;
}
