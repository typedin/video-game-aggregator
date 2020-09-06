<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Image
 * @author yourname
 */
class Image
{
    const DEFAULT_COVER_URLS = [
        "full" => "/img/default-full-game.jpg",
        "popular" => "/img/default-popular-game.jpg",
        "comingSoon" => "/img/default-coming-soon-game.jpg",
        "mostAnticipated" => "/img/default-most-anticipated-game.jpg",
        "recentlyReviewed" => "/img/default-recently-reviewed-game.jpg",
    ];

    const COVER_SIZE = [
        "full" => "cover_big",
        "popular" => "cover_big",
        "comingSoon" => "cover_small",
        "recentlyReviewed" => "cover_big",
        "mostAnticipated" => "cover_small",
    ];

    public $url;
    
    public function __construct($url)
    {
        $this->url = $url;
    }

    public static function cover(array $params, String $type): Image
    {
        if (! isset($params["cover"]["url"])) {
            return new Image(Image::DEFAULT_COVER_URLS[$type]);
        }

        $url = Image::changeRequestedSizeOfImage(
            $params["cover"]["url"],
            Image::COVER_SIZE[$type],
            "thumb"
        );

        return new Image($url);
    }
    
    public function huge()
    {
        return $this->changeRequestedSizeOfImage($this->url, "original");
    }

    public function big()
    {
        return $this->changeRequestedSizeOfImage($this->url, "cover_big");
    }

    private function changeRequestedSizeOfImage($url, $needle, $haystack="thumb")
    {
        return Str::replaceFirst($haystack, $needle, $url);
    }
}
