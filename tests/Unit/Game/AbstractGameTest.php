<?php

namespace Tests\Unit\Game;

use App\Game\AbstractGame;
use PHPUnit\Framework\TestCase;

class AbstractGameTest extends TestCase
{
    /**
     * @test
     */
    public function it_cannot_be_instanciate_without_a_name_key()
    {
        $this->expectExceptionMessage("Trying to instanciate a game without a name");

        $paramsWithNoName = [ "slug" => "a-slug" ];

        new class($paramsWithNoName) extends AbstractGame {
        };
    }

    /**
     * @test
     */
    public function it_cannot_be_instanciate_without_a_slug_key()
    {
        $this->expectExceptionMessage("Trying to instanciate a game without a slug");

        $paramsWithSlug = [ "name" => "a name" ];

        new class($paramsWithSlug) extends AbstractGame {
        };
    }
}
