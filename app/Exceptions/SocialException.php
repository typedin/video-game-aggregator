<?php

namespace App\Exceptions;

class SocialException extends \InvalidArgumentException
{
    public static function noCategory(int $id)
    {
        return new SocialException("Could not find a category for this id ({$id}).");
    }
}
