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
use App\Image;

/**
 * Class Game
 * @author typedin
 */
final class FullGame extends AbstractGame
{
    use Companiable,
        Coverable,
        Genreable,
        Platformable,
        Rateable,
        ReleaseDatable,
        Summarizable;

    public function getScreenshots()
    {
        return collect($this->getParams("screenshots"))
            ->pluck("url")
            ->filter()
            ->map(function ($url) {
                return new Image($url);
            });
    }
}
