<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ViewGameTest extends TestCase
{
    /**
     *  @test
     */
    public function the_game_page_shows_correct_game_info()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );

        Http::fake([
            "https://api-v3.igdb.com/games/" =>
                Http::response([$decodedJson], 200, ["Headers"])
        ]);

        $response = $this->get(route("games.show", 'tears-of-avia'));

        $response->assertStatus(200)
            ->assertSee("VALORANT")
            ->assertSee("PC")
            ->assertSee("Shooter, Tactical")
            ->assertSee("Riot Games")
            ->assertSee("//images.igdb.com/igdb/image/upload/t_cover_big/co2ade.jpg");

        $response->assertSee("https://www.facebook.com/PlayVALORANT")
                 ->assertSee("https://playvalorant.com/")
                 ->assertSee("https://twitter.com/PlayVALORANT")
                 ->assertSee("https://www.instagram.com/PlayVALORANTOfficial");
    }
}
