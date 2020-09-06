<?php

namespace App;

use App\Contracts\Game;
use App\Social;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Game
 * @author typedin
 */
class FullGame implements Game
{
    private $game;

    public $companies;
    public $cover;
    public $genres;
    public $memberRating;
    public $rating;
    public $screenshots;
    public $similarGames;
    public $socials;
    public $summary;
    public $trailers;

    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->summary = $this->passedSummaryOrDefault($this->getParams());
        $this->genres = $this->formatGenresOrDefault();
        $this->screenshots = $this->enrichScreenshots();
        $this->companies = $this->formatCompanies();
        $this->cover = Image::cover($this->getParams(), "full");
        $this->memberRating = $this->formatRatingOrDefault("aggregated_rating");
        $this->rating = $this->formatRatingOrDefault("rating");
        $this->similarGames = $this->enrichSimilarGames();
        $this->socials = Social::createFromApiResponse($this->getParams());
        $this->trailers = $this->formatTrailers();
    }

    public function getName(): String
    {
        return $this->game->getName();
    }

    public function getSlug(): String
    {
        return $this->game->getSlug();
    }

    public function getParams(): array
    {
        return $this->game->getParams();
    }
    public function getPlatforms()
    {
        return $this->game->platforms;
    }

    public function getReleaseDate()
    {
        return $this->game->releaseDate;
    }

    private function formatGenresOrDefault(): string
    {
        return collect($this->getparams()["genres"])->pluck("name")->filter()->join(", ");
    }

    private function formatCompanies(): string
    {
        return collect($this->getParams()["involved_companies"])->pluck("company.name")->filter()->join(", ");
    }

    private function formatRatingOrDefault($key)
    {
        if (! isset($this->getParams()[$key])) {
            return Rating::fromEmpty();
        }

        return Rating::toString($this->getParams()[$key]);
    }

    private function passedSummaryOrDefault()
    {
        if (! isset($this->getParams()["summary"])) {
            return "No summary yet";
        }

        return $this->getParams()["summary"];
    }


    private function enrichScreenshots(int $nbOfScreenshots=6): array
    {
        if (!isset($this->getParams()["screenshots"])) {
            return [];
        }

        return collect($this->getParams()["screenshots"])
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

    private function enrichSimilarGames($nbofGames=6)
    {
        return collect($this->getParams()["similar_games"])
            ->map(function ($data) {
                return new SimilarGame(new BaseGame($data), $data);
            })->take($nbofGames);
    }

    private function formatTrailers(): Collection
    {
        return collect($this->getParams()["videos"])
            ->map(function ($video) {
                return "https://youtube.com/watch/".$video["video_id"];
            });
    }
}
