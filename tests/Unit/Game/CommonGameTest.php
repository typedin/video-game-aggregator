<?php

namespace Tests\Unit;

use App\BaseGame;
use App\CommonGame;
use PHPUnit\Framework\TestCase;

class CommonGameTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_a_common_game()
    {
        $decodedJson = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);
        
        $game = new CommonGame(new BaseGame($decodedJson));

        $this->assertEquals("Cyberpunk 2077", $game->getName());
        $this->assertEquals("cyberpunk-2077", $game->getSlug());
        $this->assertEquals("84%", $game->rating);
        $this->assertEquals("PC, PS4, XONE, Stadia", $game->platforms);
        $this->assertEquals("Nov 19, 2020", $game->releaseDate);
    }
}
