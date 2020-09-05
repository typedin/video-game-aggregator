<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Social;

/**
 * Class Game
 * @author typedin
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
        "recentlyReviewed" => "cover_big",
        "mostAnticipated" => "cover_small",
    ];


    public $name;
    public $slug;

    private function __construct(array $params)
    {
        // should throw here
        $this->name = $params["name"];
        $this->slug = $params["slug"];
    }

    public static function full($params): Game
    {
        $game = new Game($params);

        $game->summary = $game->passedSummaryOrDefault($params);
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

        $game->trailers = $game->formatTraillers($params);

        $game->socials = Social::createFromApiResponse($params);
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

        return $this->changeRequestedSizeOfImage(
            $params["cover"]["url"],
            $this->coverSizes[$type],
            "thumb"
        );
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
                return
                    [
                        "huge" => $this->changeRequestedSizeOfImage($url, "original", "thumb"),
                        "big" => $this->changeRequestedSizeOfImage($url, "cover_big", "thumb"),
                    ];
            })
            ->take(9)
            ->toArray();
    }

    private function changeRequestedSizeOfImage($url, $needle, $haystack="thumb")
    {
        return Str::replaceFirst($haystack, $needle, $url);
    }

    private function enrichSimilarGames($params)
    {
        $result = [];
        foreach ($params["similar_games"] as $data) {
            $game = new Game($data);
            $game->platforms = $game->formatPlaforms($data);
            $game->slug = $data["slug"];
            $game->coverUrl = $game->passedCoverUrlOrDefault($data, "popular");
            $game->rating = $game->formatRatingOrDefault(
                $data,
                "rating"
            );

            $result[] = $game;
        }

        return collect($result)->take(6);
    }

    private function formatTraillers(array $params): Collection
    {
        return collect($params["videos"])
            ->map(function ($video) {
                return "https://youtube.com/watch/".$video["video_id"];
            });
    }
}
