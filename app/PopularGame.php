<?php

namespace App;

use App\Contracts\Game;
use Carbon\Carbon;

class PopularGame implements Game
{
    private $game;

    public $cover;
    public $platforms;
    public $rating;
    public $releaseDate;
    public $summary;


    public function __construct($game)
    {
        $this->game = $game;
        $this->rating = $this->formatRatingOrDefault("rating");
        $this->cover = Image::cover($this->getParams(), "popular");
        $this->releaseDate = $this->formatDateOrDefault();
        $this->platforms = $this->formatPlaforms();
        $this->summary = $this->formatSummaryOrDefault();
    }

    public function getName(): String
    {
        return $this->game->getName();
    }

    public function getSlug(): String
    {
        return $this->game->slug;
    }


    public function getParams(): array
    {
        return $this->game->getParams();
    }
    private function formatPlaforms(): string
    {
        return collect($this->getParams()["platforms"])->pluck("abbreviation")->filter()->join(", ");
    }

    private function formatDateOrDefault()
    {
        if (! isset($this->getParams()["first_release_date"])) {
            return "No date yet";
        }

        return Carbon::parse($this->getParams()["first_release_date"])->format('M d, Y');
    }

    private function formatRatingOrDefault($key)
    {
        if (! isset($this->getParams()[$key])) {
            return Rating::fromEmpty();
        }

        return Rating::toString($this->getParams()[$key]);
    }

    private function formatSummaryOrDefault()
    {
        if (! isset($this->getParams()["summary"])) {
            return "No summary yet";
        }

        return $this->getParams()["summary"];
    }
}
