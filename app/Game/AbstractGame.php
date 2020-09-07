<?php

namespace App\Game;

use App\Exception\GameException;

class AbstractGame
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

    protected function getParams($key=null)
    {
        if ($key) {
            return $this->params[$key];
        }

        return $this->params;
    }
}
