<?php

namespace App;

use Carbon\Carbon;

/**
 * Class Game
 * @author yourname
 */
class Game
{
    private $defaultCoverUrls = [
        "popular" => "/img/default-popular-game.jpg",
        "comingSoon" => "/img/default-coming-soon-game.jpg",
        "mostAnticipated" => "/img/default-most-anticipated-game.jpg",
        "recentlyReviewed" => "/img/default-recently-reviewed-game.jpg",
    ];

    public static function popular(array $params): Game
    {
        $game = new Game();

        $game->name = $params["name"];
        $game->platforms = $game->formatPlaforms($params);
        $game->rating = $game->formatRatingOrDefault($params);
        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }

    public static function recentlyReviewed(array $params): Game
    {
        $game = new Game();

        $game->name = $params["name"];
        $game->platforms = $game->formatPlaforms($params);
        $game->rating = $game->formatRatingOrDefault($params);
        $game->summary = $game->passedSummaryOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }
    
    public static function mostAnticipated(array $params): Game
    {
        $game = new Game();

        $game->name = $params["name"];
        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }

    public static function comingSoon(array $params): Game
    {
        $game = new Game();

        $game->name = $params["name"];
        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }

    private function passedCoverUrlOrDefault(array $params, string $type): String
    {
        if (! isset($params["cover"]["url"])) {
            return $this->defaultCoverUrls[$type];
        }
        return $params["cover"]["url"];
    }

    private function formatPlaforms(array $params): String
    {
        return join(
            ', ',
            collect($params["platforms"])
                ->pluck("abbreviation")
                ->filter()
                ->toArray()
        );
    }

    private function formatDateOrDefault($params)
    {
        if (! isset($params["first_release_date"])) {
            return "No date yet";
        }
        return Carbon::parse($params["first_release_date"])->format('M d, Y');
    }

    private function formatRatingOrDefault(array $params)
    {
        if (! isset($params["rating"])) {
            return "N/A";
        }
        return round($params["rating"])."%";
    }

    private function passedSummaryOrDefault(array $params)
    {
        if (! isset($params["summary"])) {
            return "No summary yet";
        }
        return $params["summary"];
    }
}
