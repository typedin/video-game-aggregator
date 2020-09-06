<?php

namespace App;

use App\Contracts\Game;

class SimilarGame implements Game
{
    private $game;

    public function __construct(Game $game, $params)
    {
        $this->game = $game;
        $this->platforms = $this->formatPlaforms($params);
        $this->cover = Image::cover($params, "popular");
        $this->rating = $this->formatRatingOrDefault(
            $params,
            "rating"
        );
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
    private function formatPlaforms(array $params): string
    {
        return collect($params["platforms"])->pluck("abbreviation")->filter()->join(", ");
    }

    private function formatRatingOrDefault(array $params, $key)
    {
        if (! isset($params[$key])) {
            return Rating::fromEmpty();
        }

        return Rating::toString($params[$key]);
    }
}
