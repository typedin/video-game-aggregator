<?php

namespace Tests\Unit\Game;

use App\Game\SimilarGame;
use PHPUnit\Framework\TestCase;

class SimilarGameTest extends TestCase
{
    private function decodeJson()
    {
        return [
            "id"=> 13196,
            "cover"=> [
                "id"=> 81827,
                "url"=> "//images.igdb.com/igdb/image/upload/t_thumb/co1r4z.jpg"
            ],
            "name"=> "Tears of Avia",
            "platforms"=> [
                [
                    "id"=> 6,
                    "abbreviation"=> "PC"
                ],
                [
                    "id"=> 14,
                    "abbreviation"=> "Mac"
                ],
                [
                    "id"=> 49,
                    "abbreviation"=> "XONE"
                ]
            ],
            "slug"=> "tears-of-avia"
        ];
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $game = new SimilarGame($this->decodeJson());

        $this->assertEquals("Tears of Avia", $game->name);
        $this->assertEquals("tears-of-avia", $game->slug);
        $this->assertEquals("PC, Mac, XONE", $game->getFormattedPlatforms());
        $this->assertEquals("N/A", $game->getFormattedRating("aggregated_rating"));
        $this->assertInstanceOf(\App\Image::class, $game->getCover());
    }
}
