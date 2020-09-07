<?php

namespace App\Game;

use App\Game\Traits\Coverable;
use App\Game\Traits\Platformable;
use App\Game\Traits\Rateable;
use App\Game\Traits\ReleaseDatable;
use App\Game\Traits\Summarizable;

final class RecentlyReviewedGame extends AbstractGame
{
    use ReleaseDatable, Coverable, Rateable, Platformable, Summarizable;
}
