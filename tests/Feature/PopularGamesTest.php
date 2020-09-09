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
    /**
     * @test
     */
    public function it_shows_popular_games()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/many-popular-games.json"),
            true
        );

        Livewire::test(PopularGames::class)
            ->assertSet("popularGames", []);

        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response([$decodedJson], 200, ["Headers"])
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
