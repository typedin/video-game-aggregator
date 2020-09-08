<?php

namespace App;

use App\Exceptions\SocialException;
use Illuminate\Support\Collection;

/**
 * Class Social
 * @author typedin
 */
class Social
{
    const lookupTable = [
            [
                "categoryId" => 1,
                "name" => "website"
            ],
            [
                "categoryId" => 4,
                "name" => "facebook"
            ],
            [
                "categoryId" => 5,
                "name" => "twitter"
            ],
            [
                "categoryId" => 8,
                "name" => "instagram"
            ],
        ];

    public $url;
    public $name;

    /**
     * @param SocialValues $values [TODO:description]
     */
    public function __construct(SocialValues $values)
    {
        $this->url = $values->url;
        $this->name = $this->findCategoryFromId($values->categoryId);
    }

    /**
     *
     * @param int $categoryId the passed by the value object
     *
     * @return string name found in the lookup table
     */
    private function findCategoryFromId(int $categoryId): String
    {
        $category = collect(self::lookupTable)
             ->where("categoryId", $categoryId)
             ->pluck("name")
             ->first();

        if (is_null($category)) {
            throw SocialException::noCategory($categoryId);
        }

        return $category;
    }
}
