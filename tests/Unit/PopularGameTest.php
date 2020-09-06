<?php

namespace Tests\Unit;

use App\BaseGame;
use App\CommonGame;
use App\PopularGame;
use PHPUnit\Framework\TestCase;

class PopularGameTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_a_popular_game()
    {
        $decodedJson = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);
        
        $game = new PopularGame(new CommonGame(new BaseGame($decodedJson)));

        $this->assertEquals("Cyberpunk 2077", $game->getName());
        $this->assertEquals("84%", $game->rating);
        $this->assertEquals("//images.igdb.com/igdb/image/upload/t_cover_big/co1rft.jpg", $game->cover->url);
        $this->assertEquals("Nov 19, 2020", $game->releaseDate);
        $this->assertEquals("PC, PS4, XONE, Stadia", $game->platforms);
    }

    /**
     * @test
     */
    public function it_has_sensible_default_for_cover_url()
    {
        $decodedJsonWithoutCoverUrl = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);
        unset($decodedJsonWithoutCoverUrl["cover"]["url"]);

        $game = new PopularGame(new CommonGame(new BaseGame($decodedJsonWithoutCoverUrl)));

        $this->assertEquals("/img/default-popular-game.jpg", $game->cover->url);
    }

    
    /**
     * @test
     */
    public function it_has_sensible_default_for_rating()
    {
        $decodedJsonWithoutRating = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);
        unset($decodedJsonWithoutRating["rating"]);

        $game = new PopularGame(new CommonGame(new BaseGame($decodedJsonWithoutRating)));

        $this->assertEquals("N/A", $game->rating);
    }

    /**
     * @test
     */
    public function it_default_to_sensible_default_date()
    {
        $decodedJsonWithoutDate = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-coming-soon-game.json"), true);
        unset($decodedJsonWithoutDate["first_release_date"]);

        $game = new PopularGame(new CommonGame(new BaseGame($decodedJsonWithoutDate)));

        $this->assertEquals("No date yet", $game->releaseDate);
    }

    /**
     * @test
     */
    public function it_default_to_sensible_default_summary()
    {
        $decodedJsonWithoutSummary = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-recently-reviewed-game.json"), true);
        unset($decodedJsonWithoutSummary["summary"]);

        $game = new PopularGame(new CommonGame(new BaseGame($decodedJsonWithoutSummary)));

        $this->assertEquals("No summary yet", $game->summary);
    }
}
