<?php

namespace App;

use Illuminate\Support\Collection;

/**
 * Class Social
 * @author typedin
 */
class Social
{
    const lookupTable = [
            [
                "category" => 1,
                "name" => "website"
            ],
            [
                "category" => 4,
                "name" => "facebook"
            ],
            [
                "category" => 5,
                "name" => "twitter"
            ],
            [
                "category" => 8,
                "name" => "instagram"
            ],
        ];


    public function __construct(array $params)
    {
        $this->name = $params["name"];
        $this->url = $params["url"];
    }

    public static function createFromApiResponse(array $params): Collection
    {
        return collect($params["websites"])
            ->whereIn(
                "category",
                collect(self::lookupTable)->pluck("category")
            )
            ->map(function ($website) {
                return new Social([
                    "url" => $website["url"],
                    "name" => collect(self::lookupTable)->where("category", $website["category"])->pluck("name")->first(),
                ]);
            })->values();
    }
}
