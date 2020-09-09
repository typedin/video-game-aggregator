<?php

namespace Tests\Feature;

use App\Http\Livewire\PopularGames;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class PopularGamesTest extends TestCase
{
    const FIXTURE = "/../__fixtures__/many-popular-games.json";

    private function decodeJson()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__.self::FIXTURE),
            true
        );
        return $decodedJson;
    }

    /**
     * @test
     */
    public function it_shows_popular_games()
    {
        Livewire::test(PopularGames::class)
            ->assertSet("popularGames", []);

        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response($this->decodeJson(), 200, ["Headers"])
        ]);

        Livewire::test(PopularGames::class)
            ->call("load")
            ->assertSee("Marvel's Avengers")
            ->assertSee("Necrobarista")
            ->assertSee("Factorio")
            ->assertSee("Watch Dogs: Legion")
            ->assertSee("Fae Tactics")
            ->assertSee("Diabotical")
            ->assertSee("Genshin Impact")
            ->assertSee("Ghost of Tsushima")
            ->assertSee("Spelunky 2")
            ->assertSee("Is It Wrong to Try to Pick Up Girls in a Dungeon? Infinite Combate")
            ->assertSee("Röki")
            ->assertSee("Spiritfarer")
        ;
    }
}
