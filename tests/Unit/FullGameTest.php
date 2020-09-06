<?php

namespace Tests\Unit;

use App\BaseGame;
use App\FullGame;
use App\CommonGame;
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

        $game = new FullGame(
            new CommonGame(
                new BaseGame($decodedJson)
            )
        );

        $this->assertEquals("80%", $game->rating);
        $this->assertEquals("PC", $game->getPlatforms());
        $this->assertEquals("VALORANT", $game->getName());
        $this->assertEquals("78%", $game->memberRating);
        $this->assertEquals("Riot Games", $game->companies);
        $this->assertEquals("Jun 02, 2020", $game->getReleaseDate());
        $this->assertEquals("Shooter, Tactical", $game->genres);
        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_big/co2ade.jpg",
            $game->cover->url
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

        $basicGame = new BaseGame($decodedJson);
        $commonGame = new CommonGame($basicGame, $decodedJson);
        $game = new FullGame($commonGame, $decodedJson);

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

        $game = new FullGame(new CommonGame(new BaseGame($decodedJson)));


        $this->assertEquals(3, count($game->trailers));
        $this->assertEquals(
            "https://youtube.com/watch/4iGU6PctOBg",
            $game->trailers->first()
        );
    }

    /**
     * @test
     */
    public function it_can_handle_response_with_no_video()
    {
        $decodedJsonWithNoVideo = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );
        unset($decodedJsonWithNoVideo["videos"]);

        $game = new FullGame(new CommonGame(new BaseGame($decodedJsonWithNoVideo)));

        $this->assertEquals(0, count($game->trailers));
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

        $basicGame = new BaseGame($decodedJson);
        $commonGame = new CommonGame($basicGame, $decodedJson);
        $game = new FullGame($commonGame, $decodedJson);

        $this->assertEquals(6, count($game->similarGames));
        $this->assertEquals("Tears of Avia", $game->similarGames[0]->getName());
        $this->assertEquals("tears-of-avia", $game->similarGames[0]->getSlug());
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

        $basicGame = new BaseGame($decodedJson);
        $commonGame = new CommonGame($basicGame, $decodedJson);
        $game = new FullGame($commonGame, $decodedJson);

        $this->assertEquals(4, count($game->socials));
        $this->assertEquals("https://www.facebook.com/PlayVALORANT", $game->socials[0]->url);
    }
}
