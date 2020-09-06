<?php

namespace App\Exceptions;

use InvalidArgumentException;

/**
 * Class ParamsForSocialException
 * @author yourname
 */
class ParamsForSocialException extends InvalidArgumentException
{
    /**
     * Called when no top level websites key was found
     *
     * @return ParamsForSocialException
     */
    public static function noWebsitesKey(): ParamsForSocialException
    {
        return new self("No websites keys found.");
    }

    /**
     * Called whe no url key was found on a gameField
     *
     * @param array $gameField
     *
     * @return ParamsForSocialException
     */
    public static function noUrlKeyFound($gameField): ParamsForSocialException
    {
        return new self("No url found for game ".self::idOrFallBackMessage($gameField).".");
    }

    /**
     * Called when an invalid url was found
     *
     * @param array $gameField
     *
     * @return ParamsForSocialException
     */
    public static function invalidUrl($gameField): ParamsForSocialException
    {
        return new self("No valid url found for game ".self::idOrFallBackMessage($gameField).".");
    }

    /**
     * Called when no category key was found on a gameField
     *
     * @param array $gameField
     *
     * @return ParamsForSocialException
     */
    public static function noCategoryKeyFound($gameField): ParamsForSocialException
    {
        return new self("No category found for game ".self::idOrFallBackMessage($gameField).".");
    }

    /**
     * Called when an invalid category was found on a gameField
     *
     * @param array $gameField
     *
     * @return ParamsForSocialException
     */
    public static function invalidCategory($gameField): ParamsForSocialException
    {
        return new self("No valid category found for game ".self::idOrFallBackMessage($gameField).".");
    }

    /**
     * Helper method to format the exception message
     *
     * @param array $gameField
     *
     * @return String game name or default message
     */
    private function idOrFallBackMessage($gameField): String
    {
        return isset($gameField["game"]) ? "{$gameField['game']}" : "with no ID";
    }
}
