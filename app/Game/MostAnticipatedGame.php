<?php

namespace App\Game;

use App\Exception\GameException;
use App\Image;
use Carbon\Carbon;

class MostAnticipatedGame
{
    public $name;
    public $slug;

    private $params;
    
    public function __construct(array $params)
    {
        if (! array_key_exists("name", $params)) {
            throw GameException::noName();
        }
        $this->name = $params["name"];

        if (! array_key_exists("slug", $params)) {
            throw GameException::noSlug();
        }
        $this->slug = $params["slug"];
        
        $this->params = $params;
    }
    
    public function getReleaseDate(): String
    {
        if (! isset($this->getParams()["first_release_date"])) {
            return "No date yet";
        }

        return Carbon::parse($this->getParams()["first_release_date"])->format('M d, Y');
    }

    public function getCover(): Image
    {
        return Image::cover($this->getParams("cover")["url"], "full");
    }

    private function getParams($key=null)
    {
        if ($key) {
            return $this->params[$key];
        }

        return $this->params;
    }
}
