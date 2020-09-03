<?php

namespace Tests\Unit;

use App\Game;
use PHPUnit\Framework\TestCase;

class FullGameTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_a_full_game()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );

        $game = Game::full($decodedJson);

        $this->assertEquals("80%", $game->rating);
        $this->assertEquals("PC", $game->platforms);
        $this->assertEquals("VALORANT", $game->name);
        $this->assertEquals("78%", $game->memberRating);
        $this->assertEquals("Riot Games", $game->companies);
        $this->assertEquals("Jun 02, 2020", $game->releaseDate);
        $this->assertEquals("Shooter, Tactical", $game->genres);
        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_big/co2ade.jpg",
            $game->coverUrl
        );
    }


    /**
     * @test
     */
    public function it_can_have_many_screenshots()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );

        $game = Game::full($decodedJson);

        $this->assertEquals(6, count($game->screenshots));
        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_big/sc811g.jpg",
            $game->screenshots[0]["big"]
        );
        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_original/sc811g.jpg",
            $game->screenshots[0]["huge"]
        );
    }

    /**
     * @test
     */
    public function it_can_have_trailler()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );

        $game = Game::full($decodedJson);

        $this->assertEquals(3, count($game->trailers));
        $this->assertEquals(
            "https://youtube.com/watch/4iGU6PctOBg",
            $game->trailers->first()
        );
    }

    /**
     * @test
     */
    public function it_can_have_many_similar_games()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );

        $game = Game::full($decodedJson);

        $this->assertEquals(6, count($game->similarGames));
    }

    /**
     * @test
     */
    public function it_can_have_socials()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );

        $game = Game::full($decodedJson);

        $this->assertEquals(3, count($game->socials));
        $this->assertEquals("https://playvalorant.com/", $game->socials["website"]);
        $this->assertEquals("https://www.facebook.com/PlayVALORANT", $game->socials["facebook"]);
        $this->assertEquals("https://www.instagram.com/PlayVALORANTOfficial", $game->socials["instagram"]);
    }
}
