<?php

namespace App\Presenter;

use App\Game;

/**
 * Class GamePresenter
 * @author typedin
 */
class GamePresenter
{
    public static function populareGame(array $decodedJson): Game
    {
        $params = [
            "name" => $decodedJson["name"],
            "cover" => $decodedJson["cover"],
            "rating" => $decodedJson["rating"],
            "platforms" => $decodedJson["platforms"],
            "releaseDate" => $decodedJson["first_release_date"],
        ];

        return new Game($params);
    }
}
