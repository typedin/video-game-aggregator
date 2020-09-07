<?php

namespace Tests\Unit\Game;

use App\Game\ComingSoonGame;
use PHPUnit\Framework\TestCase;

class ComingSoonGameTest extends TestCase
{
    private function decodedJson($key=null)
    {
        return json_decode(
            file_get_contents(
                __DIR__."/../../__fixtures__/one-coming-soon-game.json"
            ),
            true
        );
    }

    /**
     * @test
     */
    public function it_has_everything_for_a_view()
    {
        $game = new ComingSoonGame($this->decodedJson());

        $this->assertEquals("Cyberpunk 2077", $game->name);
        $this->assertEquals("cyberpunk-2077", $game->slug);
        $this->assertEquals("Nov 19, 2020", $game->getReleaseDate());
        $this->assertInstanceOf(\App\Image::class, $game->getCover());
    }

    /**
     * @test
     */
    public function it_cannot_be_instanciated_without_a_name()
    {
        $dataWithoutName = $this->decodedJson();
        unset($dataWithoutName["name"]);
    
        $this->expectException(\InvalidArgumentException::class);
        $game = new ComingSoonGame($dataWithoutName);
    }

    /**
     * @test
     */
    public function it_cannot_be_instanciated_without_a_slug()
    {
        $dataWithoutName = $this->decodedJson();
        unset($dataWithoutName["slug"]);
    
        $this->expectException(\InvalidArgumentException::class);
        $game = new ComingSoonGame($dataWithoutName);
    }
}
