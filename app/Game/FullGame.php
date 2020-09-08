<?php

namespace App\Game;

use App\Exceptions\SocialException;
use App\Game\AbstractGame;
use App\Game\Traits\Companiable;
use App\Game\Traits\Coverable;
use App\Game\Traits\Genreable;
use App\Game\Traits\Platformable;
use App\Game\Traits\Rateable;
use App\Game\Traits\ReleaseDatable;
use App\Game\Traits\Summarizable;
use App\Image;
use App\Social;
use App\SocialValues;
use App\Video;
use Illuminate\Support\Collection;

/**
 * Class Game
 *
 * @mixin \Illuminate\Support\Enumerable
 *
 * @author typedin
 *
 */
final class FullGame extends AbstractGame
{
    use Companiable, Coverable, Genreable, Platformable, Rateable, ReleaseDatable, Summarizable;

    public function getScreenshots(): Collection
    {
        if (! array_key_exists("screenshots", $this->getParams())) {
            return collect();
        }

        return collect($this->getParams("screenshots"))
        ->pluck("url")
        ->filter()
        ->map(function ($url) {
            return new Image($url);
        });
    }

    public function getTrailers(): Collection
    {
        if (! array_key_exists("videos", $this->getParams())) {
            return collect();
        }

        return collect($this->getParams("videos"))
        ->pluck("video_id")
        ->filter()
        ->map(function ($id) {
            return Video::youtube($id);
        }) ;
    }

    public function getSimilarGames($limit=6): Collection
    {
        if (! array_key_exists("similar_games", $this->getParams())) {
            return collect();
        }

        return collect($this->getParams("similar_games"))
        ->map(function ($id) {
            return new SimilarGame($id);
        })
        ->take($limit);
    }

    public function getSocials($limit=4): Collection
    {
        $socials = new Collection();

        foreach ($this->getParams("websites") as $website) {
            try {
                $socials->push(new Social(new SocialValues($website)));
            } catch (SocialException $exception) {
                // DO NOTHING
            }
        }

        return $socials->take($limit);
    }
}
