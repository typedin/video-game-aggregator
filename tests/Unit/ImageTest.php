<?php

namespace Tests\Unit;

use App\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    private $url = "//images.igdb.com/igdb/image/upload/t_thumb/co2ade.jpg";

    /**
     * @test
     */
    public function it_can_generate_a_cover_image_for_a_type_of_game()
    {
        $imageForFull = Image::cover($this->url, "full");

        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_big/co2ade.jpg",
            $imageForFull->url
        );
    }

    /**
     * @test
     */
    public function it_can_generate_a_cover_image_for_a_type_of_game_passed_in_kebab_case()
    {
        $imageForKebabCase = Image::cover($this->url, "coming-soon");

        $this->assertEquals(
            "//images.igdb.com/igdb/image/upload/t_cover_small/co2ade.jpg",
            $imageForKebabCase->url
        );
    }

    /**
     * @test
     */
    public function it_defaults_to_a_stock_cover_image_when_no_url_is_provided()
    {
        $imageForNoUrl = Image::cover(null, "coming-soon");

        $this->assertEquals(
            "/img/default-coming-soon-game.jpg",
            $imageForNoUrl->url
        );
    }
}
