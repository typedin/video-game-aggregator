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
        "similar" => "/img/default-recently-reviewed-game.jpg",
        "coming-soon" => "/img/default-coming-soon-game.jpg",
        "most-anticipated" => "/img/default-most-anticipated-game.jpg",
        "recently-reviewed" => "/img/default-recently-reviewed-game.jpg",
    ];

    const COVER_SIZE = [
        "full" => "cover_big",
        "popular" => "cover_big",
        "similar" => "cover_small",
        "coming-soon" => "cover_small",
        "recently-reviewed" => "cover_big",
        "most-anticipated" => "cover_small",
    ];

    public $url;
    
    public function __construct($url)
    {
        $this->url = $url;
    }

    public static function cover(string $url=null, String $type): Image
    {
        return new Image(Image::requestedUrlOrDefault($url, $type));
    }
    
    public function huge()
    {
        return $this->changeRequestedSizeOfImage($this->url, "original");
    }

    public function big()
    {
        return $this->changeRequestedSizeOfImage($this->url, "cover_big");
    }

    private static function changeRequestedSizeOfImage($url, $needle, $haystack="thumb")
    {
        return Str::replaceFirst($haystack, $needle, $url);
    }

    private static function requestedUrlOrDefault($url, $type)
    {
        if (! isset($url)) {
            return Image::DEFAULT_COVER_URLS[$type];
        }

        return Image::changeRequestedSizeOfImage(
            $url,
            Image::COVER_SIZE[$type],
            "thumb"
        );
    }
}
