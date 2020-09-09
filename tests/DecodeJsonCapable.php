<?php

namespace Tests;

/**
 * Trait DecodeJsonCapable
 * @author yourname
 */
trait DecodeJsonCapable
{
    private function decodeJson()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/__fixtures__/".self::FIXTURE),
            true
        );
        return $decodedJson;
    }
}
