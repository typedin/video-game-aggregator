<?php

namespace Tests\Unit\Game;

use App\Game\FullGame;
use PHPUnit\Framework\TestCase;

class FullGameTest extends TestCase
{
    private function decodedJson($key=null)
    {
        return json_decode(
            file_get_contents(
                __DIR__."/../../__fixtures__/one-full-game.json"
            ),
            true
        );
    }

    /**
     * @test
     */
    public function it_has_everything_for_a_view()
    {
        $game = new FullGame($this->decodedJson());

        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_big/co2ade.jpg",
            $game->getCover()->url
        );
        $this->assertEquals("VALORANT", $game->name);
        $this->assertEquals("Shooter, Tactical", $game->getFormattedGenres());
        $this->assertEquals("Riot Games", $game->getFormattedCompanies());
        $this->assertEquals("PC", $game->getFormattedPlatforms());
        $this->assertEquals("80%", $game->getFormattedRating("rating"));
        $this->assertEquals("78%", $game->getFormattedRating("aggregated_rating"));
        $this->assertEquals("Jun 02, 2020", $game->getReleaseDate());
    }

    /**
     * @test
     */
    public function it_can_have_many_screenshots()
    {
        $game = new FullGame($this->decodedJson());

        $this->assertEquals(6, count($game->getScreenshots()));
        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_big/sc811g.jpg",
            $game->getScreenshots()->first()->big()
        );
        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_original/sc811g.jpg",
            $game->getScreenshots()->first()->huge()
        );
    }

    /**
     * @test
     */
    public function it_can_handle_response_with_no_screenshots()
    {
        $decodedJsonWithNoScreenshots = $this->decodedJson();
        unset($decodedJsonWithNoScreenshots["screenshots"]);

        $game = new FullGame($decodedJsonWithNoScreenshots);

        $this->assertEquals(0, count($game->getScreenshots()));
    }

    /**
     * @test
     */
    public function it_can_have_trailler()
    {
        $game = new FullGame($this->decodedJson());


        $this->assertEquals(3, count($game->getTrailers()));
        $this->assertEquals(
            "https://youtube.com/watch/4iGU6PctOBg",
            $game->getTrailers()->first()->url
        );
    }

    /**
     * @test
     */
    public function it_can_handle_response_with_no_video()
    {
        $decodedJsonWithNoVideo = $this->decodedJson();
        unset($decodedJsonWithNoVideo["videos"]);

        $game = new FullGame($decodedJsonWithNoVideo);

        $this->assertEquals(0, count($game->getTrailers()));
    }

    /**
     * @test
     */
    public function it_can_have_many_similar_games()
    {
        $game = new FullGame($this->decodedJson());

        $this->assertEquals(6, count($game->getSimilarGames()));
        $this->assertEquals("Tears of Avia", $game->getSimilarGames()[0]->name);
        $this->assertEquals("tears-of-avia", $game->getSimilarGames()[0]->slug);
    }

    /**
     * @test
     */
    public function it_may_have_no_similar_games()
    {
        $decodedJsonWithNoSimilarGames = $this->decodedJson();
        unset($decodedJsonWithNoSimilarGames["similar_games"]);

        $game = new FullGame($decodedJsonWithNoSimilarGames);

        $this->assertEquals(0, count($game->getSimilarGames()));
    }

    /**
     * @test
     */
    public function it_can_have_socials()
    {
        $game = new FullGame($this->decodedJson());

        $this->assertEquals(4, count($game->getSocials()));
        $this->assertEquals("https://www.facebook.com/PlayVALORANT", $game->getSocials()->first()->url);
        $this->assertEquals("facebook", $game->getSocials()->first()->name);
    }

    /**
     * @test
     */
    public function it_may_have_no_socials()
    {
        $decodedJsonWithNoSocials = $this->decodedJson();
        unset($decodedJsonWithNoSocials["websites"]);

        $game = new FullGame($decodedJsonWithNoSocials);

        $this->assertEquals(0, count($game->getSocials()));
    }

    /**
     * @test
     */
    public function it_handles_socials_exception_when_wrong_data_is_passed()
    {
        $dataWithOnlyFourValidWebsites = $this->decodedJson();
        array_push($dataWithOnlyFourValidWebsites["websites"], [
            "id"=> 136789,
            "category"=> 4242424242,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://www.facebook.com/something-real",
            "checksum"=> "00000000-0000-0000-0000-000000000000"
        ]);

        $game = new FullGame($dataWithOnlyFourValidWebsites);

        $this->assertEquals(4, count($game->getSocials()));
    }
}
