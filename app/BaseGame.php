<?php

namespace App;

use \App\Contracts\Game;

/**
 * Class BaseGame
 *
 * @author typedin
 */
class BaseGame implements Game
{
    protected $name;
    protected $slug;
    protected $params;

    /**
     *
     * @param array $params
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $params)
    {
        if (! key_exists("name", $params)) {
            throw new \InvalidArgumentException("No key for name was found");
        }
        if (! strlen($params["name"])) {
            throw new \InvalidArgumentException("No valid name was found");
        }
        $this->name = $params["name"];

        if (! key_exists("slug", $params)) {
            throw new \InvalidArgumentException("No key for slug was found");
        }
        if (! strlen($params["slug"])) {
            throw new \InvalidArgumentException("No valid slug was found");
        }
        $this->slug = $params["slug"];

        $this->params = $params;
    }
    
    /**
     * Name getter
     *
     * @return String name
     */
    public function getName(): String
    {
        return $this->name;
    }

    /**
     * Slug getter
     *
     * @return String slug
     */
    public function getSlug(): String
    {
        return $this->slug;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
