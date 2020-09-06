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
class CommonGame implements Game
{
    protected $game;

    public $rating;
    public $platforms;
    public $releaseDate;

    public function __construct(Game $game)
    {
        $this->game = $game;
        $this->rating = $this->formatRatingOrDefault("rating");
        $this->platforms = $this->formatPlaforms();
        $this->releaseDate = $this->formatDateOrDefault();
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
}
