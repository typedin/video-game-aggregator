<?php

namespace App;

/**
 * Class GameDecorator
 * @author yourname
 */
abstract class GameDecorator implements Game
{
    protected Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }
}
