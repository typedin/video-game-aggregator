<?php

namespace Tests\Unit;

use App\ParamsForSocial;
use PHPUnit\Framework\TestCase;

class ParamsForSocialTest extends TestCase
{
    const VALID = ["websites" => [
        [
            "id"=> 136789,
            "category"=> 4,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://www.facebook.com/PlayVALORANT",
            "checksum"=> "24f338bd-9c46-5168-fb5b-05e9278e0ca6"
        ],
        [
            "id"=> 137847,
            "category"=> 14,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://www.reddit.com/r/VALORANT",
            "checksum"=> "e393ed05-af0b-78e2-333c-0261c9e1a94a"
        ],
        [
            "id"=> 138017,
            "category"=> 3,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://en.wikipedia.org/wiki/Valorant",
            "checksum"=> "1325811b-bef3-7761-d7a2-e3d6b106db5f"
        ],
        [
            "id"=> 139755,
            "category"=> 1,
            "game"=> 126459,
            "trusted"=> false,
            "url"=> "https://playvalorant.com/",
            "checksum"=> "c445ed9f-3cdd-27cf-33e9-ed8f3b42c1a2"
        ],
        [
            "id"=> 139756,
            "category"=> 2,
            "game"=> 126459,
            "trusted"=> false,
            "url"=> "https://valorant.fandom.com/wiki/Valorant_Wiki",
            "checksum"=> "1344ea7d-3dd2-be18-df78-e44c0b292fa8"
        ],
        [
            "id"=> 144917,
            "category"=> 5,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://twitter.com/PlayVALORANT",
            "checksum"=> "9f584091-abaf-942b-7e9f-3695d133bf57"
        ],
        [
            "id"=> 144918,
            "category"=> 6,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://www.twitch.tv/VALORANT",
            "checksum"=> "a0b8f224-1509-8761-8213-a6ccb8633b54"
        ],
        [
            "id"=> 144919,
            "category"=> 8,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://www.instagram.com/PlayVALORANTOfficial",
            "checksum"=> "ac309dff-6e01-8b88-fd02-97b237ba6f31"
        ],
        [
            "id"=> 144920,
            "category"=> 9,
            "game"=> 126459,
            "trusted"=> true,
            "url"=> "https://www.youtube.com/PlayVALORANT",
            "checksum"=> "99f9f348-cd50-54ee-2552-0b8a2bb6a34d"
        ],
        [
            "id"=> 144921,
            "category"=> 18,
            "game"=> 126459,
            "trusted"=> false,
            "url"=> "https://discord.com/invite/VALORANT",
            "checksum"=> "26f12ca9-4aec-a1e1-20b3-56e4526c8b72"
        ]
    ]];

    /**
     * @test
     */
    public function it_must_be_instanciate_with_an_array_with_a_websites_key()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No websites keys found.");

        $sut = new ParamsForSocial([]);
    }

    /**
     * @test
     */
    public function it_must_have_a_url_key()
    {
        $invalid = [
            "websites" => [
                [
                    "game"=> 126459,
                    "category"=> 1,
                ]
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No url found for game 126459.");

        $sut = new ParamsForSocial($invalid);
    }

    /**
     * @test
     */
    public function url_must_be_an_url()
    {
        $invalid = [
            "websites" => [
                [
                    "game"=> 126459,
                    "category"=> 1,
                    "url"=> "not a url",
                ]
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No valid url found for game 126459.");

        $sut = new ParamsForSocial($invalid);
    }

    /**
     * @test
     */
    public function it_must_have_a_category_key()
    {
        $invalid = [
            "websites" => [
                [
                    "game"=> 126459,
                    "url"=> "https://www.facebook.com/PlayVALORANT",
                ]
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No category found for game 126459.");

        $sut = new ParamsForSocial($invalid);
    }


    /**
     * @test
     */
    public function category_must_be_an_int()
    {
        $invalid = [
            "websites" => [
                [
                    "game"=> 126459,
                    "category"=> "not an int",
                    "url"=> "https://www.facebook.com/PlayVALORANT",
                ]
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No valid category found for game 126459.");

        $sut = new ParamsForSocial($invalid);
    }

    /**
     * @test
     */
    public function it_falls_back_when_no_game_key_is_usable()
    {
        $invalid = [
            "websites" => [
                [
                    "url"=> "https://www.facebook.com/PlayVALORANT",
                ]
            ]
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No category found for game with no ID.");

        $sut = new ParamsForSocial($invalid);
    }
}
