<?php

namespace App;

use App\Social;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Game
 * @author typedin
 */
class CommonGame implements GameInterface
{
    protected $game;

    public $rating;
    public $platforms;
    public $releaseDate;

    public function __construct($game, array $params)
    {
        $this->game = $game;
        $this->rating = $this->formatRatingOrDefault($params, "rating");
        $this->platforms = $this->formatPlaforms($params);
        $this->releaseDate = $this->formatDateOrDefault($params);
    }
    
    public function getName(): String
    {
        return $this->game->name;
    }

    public function getSlug(): String
    {
        return $this->game->slug;
    }

    private function formatPlaforms(array $params): string
    {
        return collect($params["platforms"])->pluck("abbreviation")->filter()->join(", ");
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
            return Rating::fromEmpty();
        }

        return Rating::toString($params[$key]);
    }
}
