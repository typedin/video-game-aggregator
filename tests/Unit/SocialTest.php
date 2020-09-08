<?php

namespace Tests\Unit;

use App\Social;
use App\SocialValues;
use PHPUnit\Framework\TestCase;

class SocialTest extends TestCase
{
    public function setUp(): void
    {
        $this->social_value_mock = $this->getMockBuilder(SocialValues::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }
    /**
     * @test
     */
    public function it_has_a_name()
    {
        $this->social_value_mock->categoryId = 8;
        $this->social_value_mock->url = "https://www.instagram.com/miroir.miroir.art/";

        $sut = new Social($this->social_value_mock);

        $this->assertEquals("instagram", $sut->name);

        $this->assertEquals(
            "https://www.instagram.com/miroir.miroir.art/",
            $sut->url
        );
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_passing_an_id_that_does_not_exist()
    {
        $this->social_value_mock->categoryId = 4242424242;
        $this->social_value_mock->url = "https://www.instagram.com/miroir.miroir.art/";

        $this->expectExceptionMessage("Could not find a category for this id (4242424242).");

        $sut = new Social($this->social_value_mock);
    }
}
