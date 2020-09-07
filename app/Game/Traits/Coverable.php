<?php

namespace App\Game\Traits;

use App\Image;
use Illuminate\Support\Str;
use ReflectionClass;

trait Coverable
{
    private function extractAdjectiveFromClassName(): String
    {
        return Str::kebab(
            str_replace(
                "Game",
                "",
                (new ReflectionClass($this))->getShortName()
            )
        );
    }

    public function getCover(): Image
    {
        if (! array_key_exists("url", $this->getParams("cover"))) {
            return Image::cover(null, $this->extractAdjectiveFromClassName());
        }

        return Image::cover($this->getParams("cover")["url"], "full");
    }
}
