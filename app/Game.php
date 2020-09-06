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
        $game->screenshots = $game->enrichScreenshots($params);
        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->rating = $game->formatRatingOrDefault(
            $params,
            "rating"
        );
        $game->memberRating = $game->formatRatingOrDefault(
            $params,
            "aggregated_rating"
        );
        $game->cover = Image::cover($params, "full");
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
        $game->cover = Image::cover($params, "popular");

        return $game;
    }

    public static function recentlyReviewed(array $params): Game
    {
        $game = new Game($params);

        $game->platforms = $game->formatPlaforms($params);
        $game->rating = $game->formatRatingOrDefault($params, "rating");
        $game->summary = $game->passedSummaryOrDefault($params);
        $game->cover = Image::cover($params, "recentlyReviewed");

        return $game;
    }

    public static function mostAnticipated(array $params): Game
    {
        $game = new Game($params);

        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->cover = Image::cover($params, "mostAnticipated");

        return $game;
    }

    public static function comingSoon(array $params): Game
    {
        $game = new Game($params);

        $game->releaseDate = $game->formatDateOrDefault($params);
        $game->cover = Image::cover($params, "comingSoon");

        return $game;
    }

    private function formatGenresOrDefault($params): string
    {
        return collect($params["genres"])->pluck("name")->filter()->join(", ");
    }

    private function formatPlaforms(array $params): string
    {
        return collect($params["platforms"])->pluck("abbreviation")->filter()->join(", ");
    }

    private function formatCompanies(array $params): string
    {
        return collect($params["involved_companies"])->pluck("company.name")->filter()->join(", ");
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


    private function enrichScreenshots($params, int $nbOfScreenshots=6): array
    {
        if (!isset($params["screenshots"])) {
            return [];
        }

        return collect($params["screenshots"])
            ->pluck("url")
            ->filter()
            ->map(function ($url) {
                $image = new Image($url);
                return [
                    "huge" => $image->huge(),
                    "big" => $image->big()
                ];
            })
            ->take($nbOfScreenshots)
            ->toArray();
    }

    private function enrichSimilarGames($params)
    {
        $result = [];
        foreach ($params["similar_games"] as $data) {
            $game = new Game($data);
            $game->platforms = $game->formatPlaforms($data);
            $game->slug = $data["slug"];
            $game->cover = Image::cover($data, "popular");
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
