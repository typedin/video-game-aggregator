<?php

namespace App\Game;

use App\Game\Traits\Coverable;
use App\Game\Traits\ReleaseDatable;

final class MostAnticipatedGame extends AbstractGame
{
    use ReleaseDatable, Coverable;
}
