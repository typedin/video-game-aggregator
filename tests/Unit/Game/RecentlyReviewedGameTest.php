<?php

namespace Tests\Unit\Game;

use App\Game\RecentlyReviewedGame;
use PHPUnit\Framework\TestCase;

class RecentlyReviewedGameTest extends TestCase
{
    private function decodedJson($key=null)
    {
        return json_decode(
            file_get_contents(
                __DIR__."/../../__fixtures__/one-recently-reviewed-game.json"
            ),
            true
        );
    }

    /**
     * @test
     */
    public function it_has_everything_for_a_view()
    {
        $game = new RecentlyReviewedGame($this->decodedJson());

        $this->assertEquals("Desperados III", $game->name);
        $this->assertEquals("desperados-iii", $game->slug);
        $this->assertEquals("Jun 16, 2020", $game->getReleaseDate());
        $this->assertInstanceOf(\App\Image::class, $game->getCover());
        $this->assertEquals("N/A", $game->getFormattedRating("release_date"));
        $this->assertEquals("PC, PS4, XONE", $game->getFormattedPlatforms());
    }

    /**
     * @test
     */
    public function it_default_to_sensible_default_summary()
    {
        $decodedJsonWithoutSummary = $this->decodedJson();
        unset($decodedJsonWithoutSummary["summary"]);

        $game = new RecentlyReviewedGame($decodedJsonWithoutSummary);

        $this->assertEquals("No summary yet", $game->getSummary());
    }
}
