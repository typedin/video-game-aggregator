<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Game
 * @author yourname
 */
class Game
{
    private $defaultCoverUrls = [
        "full" => "/img/default-full-game.jpg",
        "popular" => "/img/default-popular-game.jpg",
        "comingSoon" => "/img/default-coming-soon-game.jpg",
        "mostAnticipated" => "/img/default-most-anticipated-game.jpg",
        "recentlyReviewed" => "/img/default-recently-reviewed-game.jpg",
    ];

    private $coverSizes = [
        "full" => "cover_big",
        "popular" => "cover_big",
        "comingSoon" => "cover_small",
        "mostAnticipated" => "cover_small",
        "recentlyReviewed" => "cover_big",
    ];


    public $name;

    private function __construct(array $params)
    {
        // should throw here
        $this->name = $params["name"];
    }
    
    public static function full($params): Game
    {
        $game = new Game($params);

        $game->platforms = $game->formatPlaforms($params);
        $game->genres = $game->formatGenresOrDefault($params);
        $game->screenshots = $game->parseScreenshots($params);
        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->rating = $game->formatRatingOrDefault(
            $params,
            "rating"
        );
        $game->memberRating = $game->formatRatingOrDefault(
            $params,
            "aggregated_rating"
        );
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);
        $game->companies = $game->formatCompanies($params);
        $game->similarGames = $game->enrichSimilarGames($params);

        return $game;
    }

    public static function popular(array $params): Game
    {
        $game = new Game($params);

        $game->platforms = $game->formatPlaforms($params);
        $game->rating = $game->formatRatingOrDefault($params, "rating");
        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }

    public static function recentlyReviewed(array $params): Game
    {
        $game = new Game($params);

        $game->platforms = $game->formatPlaforms($params);
        $game->rating = $game->formatRatingOrDefault($params, "rating");
        $game->summary = $game->passedSummaryOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }
    
    public static function mostAnticipated(array $params): Game
    {
        $game = new Game($params);

        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }

    public static function comingSoon(array $params): Game
    {
        $game = new Game($params);

        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->coverUrl = $game->passedCoverUrlOrDefault($params, __FUNCTION__);

        return $game;
    }

    private function passedCoverUrlOrDefault(array $params, string $type): String
    {
        if (! isset($params["cover"]["url"])) {
            return $this->defaultCoverUrls[$type];
        }

        return Str::replaceFirst('thumb', $this->coverSizes[$type], $params['cover']['url']);
    }

    private function formatGenresOrDefault($params): string
    {
        return join(
            ', ',
            collect($params["genres"])
                ->pluck("name")
                ->filter()
                ->toArray()
        );
    }

    private function formatPlaforms(array $params): string
    {
        return join(
            ', ',
            collect($params["platforms"])
                ->pluck("abbreviation")
                ->filter()
                ->toArray()
        );
    }

    private function formatCompanies(array $params): string
    {
        return join(
            ', ',
            collect($params["involved_companies"])
                ->pluck("company.name")
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

    private function formatRatingOrDefault(array $params, $key)
    {
        if (! isset($params[$key])) {
            return "N/A";
        }
        return round($params[$key])."%";
    }

    private function formatMemberRatingOrDefault(array $params)
    {
        if (! isset($params["aggregated_rating"])) {
            return "N/A";
        }
        return round($params["aggregated_rating"])."%";
    }

    private function passedSummaryOrDefault(array $params)
    {
        if (! isset($params["summary"])) {
            return "No summary yet";
        }
        return $params["summary"];
    }

    private function parseScreenshots(array $params): array
    {
        if (!isset($params["screenshots"])) {
            return [];
        }

        return collect($params["screenshots"])
            ->pluck("url")
            ->filter()
            ->map(function ($url) {
                return $this->changeRequestedSizeOfImage(
                    "original",
                    "thumb",
                    $url
                );
            })->toArray();
    }
    
    private function changeRequestedSizeOfImage($needle, $haystack="thumb", $url)
    {
        return Str::replaceFirst('thumb', "original", $url);
    }

    private function enrichSimilarGames($params)
    {
        $result = [];
        foreach ($params["similar_games"] as $data) {
            $game = new Game($data);
            $game->platforms = $game->formatPlaforms($data);
            $game->slug = $data["slug"];
            $game->coverUrl = $game->passedCoverUrlOrDefault($data, "popular");

            $result[] = $game;
        }

        return collect($result);
    }
}
