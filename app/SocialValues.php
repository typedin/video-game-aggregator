<?php

namespace App;

use App\Exceptions\SocialValuesException;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Class ParamForSocial
 * @author yourname
 */
class SocialValues
{
    /**
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        if (! array_key_exists("url", $fields)) {
            throw SocialValuesException::noUrlKeyFound($fields);
        }
        if (! filter_var($fields["url"], FILTER_VALIDATE_URL)) {
            throw SocialValuesException::invalidUrl($fields);
        }
        $this->url = $fields["url"];

        if (! array_key_exists("category", $fields)) {
            throw SocialValuesException::noCategoryKeyFound($fields);
        }
        if (! filter_var($fields["category"], FILTER_VALIDATE_INT)) {
            throw SocialValuesException::invalidCategory($fields);
        }
        $this->categoryId = $fields["category"];
    }
}
