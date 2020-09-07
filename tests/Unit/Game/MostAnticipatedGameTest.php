<?php

namespace Tests\Unit\Game;

use App\Game\MostAnticipatedGame;
use PHPUnit\Framework\TestCase;

class MostAnticipatedGameTest extends TestCase
{
    private function decodedJson($key=null)
    {
        return json_decode(
            file_get_contents(
                __DIR__."/../../__fixtures__/one-most-anticipated-game.json"
            ),
            true
        );
    }

    /**
     * @test
     */
    public function it_has_everything_for_a_view()
    {
        $game = new MostAnticipatedGame($this->decodedJson());

        $this->assertEquals("Cyberpunk 2077", $game->name);
        $this->assertEquals("cyberpunk-2077", $game->slug);
        $this->assertEquals("Nov 19, 2020", $game->getReleaseDate());
        $this->assertInstanceOf(\App\Image::class, $game->getCover());
    }
}
