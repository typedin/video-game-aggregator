<?php

namespace App;

use App\Exceptions\ParamsForSocialException;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Class ParamForSocial
 * @author yourname
 */
class ParamsForSocial
{
    private $fields;
    
    /**
     * [TODO:description]
     *
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        if (! array_key_exists("websites", $fields)) {
            throw ParamsForSocialException::noWebsitesKey();
        }

        foreach ($fields["websites"] as $field) {
            if (! array_key_exists("url", $field)) {
                throw ParamsForSocialException::noUrlKeyFound($field);
            }
            if (! filter_var($field["url"], FILTER_VALIDATE_URL)) {
                throw ParamsForSocialException::invalidUrl($field);
            }
            if (! array_key_exists("category", $field)) {
                throw ParamsForSocialException::noCategoryKeyFound($field);
            }
            if (! filter_var($field["category"], FILTER_VALIDATE_INT)) {
                throw ParamsForSocialException::invalidCategory($field);
            }
        }

        $this->fields = $fields;
    }

    /**
     * Getter for websites
     *
     * @return Collection websites
     */
    public function websites(): Collection
    {
        return collect($this->fields["websites"]);
    }
}
