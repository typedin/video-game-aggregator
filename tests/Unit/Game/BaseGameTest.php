<?php

namespace Tests\Unit;

use App\BaseGame;
use PHPUnit\Framework\TestCase;

class BaseGameTest extends TestCase
{
    /**
     * @test
     */
    public function it_cannot_be_instanciate_without_a_name_key()
    {
        $this->expectExceptionMessage("No key for name was found");

        new BaseGame([
            "slug" => "a-slug"
        ]);
    }

    /**
     * @test
     */
    public function it_cannot_be_instanciate_without_a_name_value()
    {
        $this->expectExceptionMessage("No valid name was found");

        new BaseGame([
            "name" => "",
            "slug" => "a-slug"
        ]);
    }

    /**
     * @test
     */
    public function it_cannot_be_instanciate_without_a_slug_key()
    {
        $this->expectExceptionMessage("No key for slug was found");

        new BaseGame([
            "name" => "a name"
        ]);
    }

    /**
     * @test
     */
    public function it_cannot_be_instanciate_without_a_slug_value()
    {
        $this->expectExceptionMessage("No valid slug was found");

        new BaseGame([
            "name" => "a name",
            "slug" => ""
        ]);
    }
}
