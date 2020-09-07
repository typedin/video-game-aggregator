<?php

namespace Tests\Unit\Game;

use App\Game\PopularGame;
use PHPUnit\Framework\TestCase;

class PopularGameTest extends TestCase
{
    private function decodedJson($key=null)
    {
        return json_decode(
            file_get_contents(
                __DIR__."/../../__fixtures__/one-popular-game.json"
            ),
            true
        );
    }

    /**
     * @test
     */
    public function it_has_everything_for_a_view()
    {
        $game = new PopularGame($this->decodedJson());

        $this->assertEquals("Cyberpunk 2077", $game->name);
        $this->assertEquals("cyberpunk-2077", $game->slug);
        $this->assertEquals("Nov 19, 2020", $game->getReleaseDate());
        $this->assertInstanceOf(\App\Image::class, $game->getCover());
        $this->assertEquals("N/A", $game->getFormattedRating("release_date"));
        $this->assertEquals("PC, PS4, XONE, Stadia", $game->getFormattedPlatforms());
    }

    /**
     * @test
     */
    public function it_has_sensible_default_for_cover_url()
    {
        $decodedJsonWithoutCoverUrl = $this->decodedJson();
        unset($decodedJsonWithoutCoverUrl["cover"]["url"]);

        $game = new PopularGame($decodedJsonWithoutCoverUrl);

        $this->assertEquals("/img/default-popular-game.jpg", $game->getCover()->url);
    }

    
    /**
     * @test
     */
    public function it_has_sensible_default_for_rating()
    {
        $decodedJsonWithoutRating= $this->decodedJson();
        unset($decodedJsonWithoutRating["rating"]);

        $game = new PopularGame($decodedJsonWithoutRating);

        $this->assertEquals("N/A", $game->getFormattedRating("release_date"));
    }

    /**
     * @test
     */
    public function it_default_to_sensible_default_date()
    {
        $decodedJsonWithoutDate = $this->decodedJson();
        unset($decodedJsonWithoutDate["first_release_date"]);

        $game = new PopularGame($decodedJsonWithoutDate);

        $this->assertEquals("No date yet", $game->getReleaseDate());
    }
}
