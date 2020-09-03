<?php

namespace Tests\Unit;

use App\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_a_popular_game()
    {
        $decodedJson = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);

        $game = Game::popular($decodedJson);

        $this->assertEquals("84%", $game->rating);
        $this->assertEquals("Cyberpunk 2077", $game->name);
        $this->assertEquals("Nov 19, 2020", $game->releaseDate);
        $this->assertEquals("PC, PS4, XONE, Stadia", $game->platforms);
        $this->assertEquals("//images.igdb.com/igdb/image/upload/t_cover_big/co1rft.jpg", $game->coverUrl);
    }

    /**
     * @test
     */
    public function it_can_have_been_recently_reviewed()
    {
        $decodedJson = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-recently-reviewed-game.json"), true);

        $game = Game::recentlyReviewed($decodedJson);

        $this->assertEquals("90%", $game->rating);
        $this->assertEquals("Desperados III", $game->name);
        $this->assertEquals("PC, PS4, XONE", $game->platforms);
        $this->assertStringContainsString("The Wild West.", $game->summary);
        $this->assertEquals("//images.igdb.com/igdb/image/upload/t_cover_big/co1r82.jpg", $game->coverUrl);
    }

    /**
     * @test
     */
    public function it_can_be_most_anticipated()
    {
        $decodedJson = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-most-anticipated-game.json"), true);

        $game = Game::mostAnticipated($decodedJson);

        $this->assertEquals("Cyberpunk 2077", $game->name);
        $this->assertEquals("Nov 19, 2020", $game->releaseDate);
        $this->assertEquals("//images.igdb.com/igdb/image/upload/t_cover_small/co1rft.jpg", $game->coverUrl);
    }

    /**
     * @test
     */
    public function it_can_be_coming_soon()
    {
        $decodedJson = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-coming-soon-game.json"), true);

        $game = Game::comingSoon($decodedJson);

        $this->assertEquals("Cyberpunk 2077", $game->name);
        $this->assertEquals("Nov 19, 2020", $game->releaseDate);
        $this->assertEquals("//images.igdb.com/igdb/image/upload/t_cover_small/co1rft.jpg", $game->coverUrl);
    }

    /**
     * @test
     */
    public function it_has_sensible_default_for_cover_url()
    {
        $decodedJsonWithoutCoverUrl = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);
        unset($decodedJsonWithoutCoverUrl["cover"]["url"]);

        $game = Game::popular($decodedJsonWithoutCoverUrl);

        $this->assertEquals("/img/default-popular-game.jpg", $game->coverUrl);
    }

    /**
     * @test
     */
    public function it_has_sensible_default_for_rating()
    {
        $decodedJsonWithoutRating = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-popular-game.json"), true);
        unset($decodedJsonWithoutRating["rating"]);

        $game = Game::popular($decodedJsonWithoutRating);

        $this->assertEquals("N/A", $game->rating);
    }

    /**
     * @test
     */
    public function it_default_to_sensible_default_date()
    {
        $decodedJsonWithoutADate = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-coming-soon-game.json"), true);
        unset($decodedJsonWithoutADate["first_release_date"]);

        $game = Game::comingSoon($decodedJsonWithoutADate);

        $this->assertEquals("No date yet", $game->releaseDate);
    }

    /**
     * @test
     */
    public function it_default_to_sensible_default_summary()
    {
        $decodedJsonWithoutSummary = json_decode(file_get_contents(__DIR__."/../__fixtures__/one-recently-reviewed-game.json"), true);
        unset($decodedJsonWithoutSummary["summary"]);

        $game = Game::recentlyReviewed($decodedJsonWithoutSummary);

        $this->assertEquals("No summary yet", $game->summary);
    }
}
