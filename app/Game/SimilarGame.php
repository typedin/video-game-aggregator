<?php

namespace App\Game;

use App\Game\Traits\Coverable;
use App\Game\Traits\Platformable;
use App\Game\Traits\Rateable;

final class SimilarGame extends AbstractGame
{
    use Platformable, Rateable, Coverable ;
}
