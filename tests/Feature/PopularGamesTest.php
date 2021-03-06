<?php

namespace Tests\Feature;

use App\Http\Livewire\Popular;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\BadDataCapable;
use Tests\DecodeJsonCapable;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class PopularGamesTest extends TestCase
{
    use DecodeJsonCapable, BadDataCapable;

    const FIXTURE = "many-popular-games.json";

    /**
     * @test
     */
    public function it_shows_popular_games()
    {
        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response($this->decodeJson(), 200, ["Headers"])
        ]);

        Livewire::test(Popular::class)
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

    /**
     * @test
     */
    public function it_logs_error_when_wrong_data_has_been_retreived()
    {
        Log::swap(new LogFake);

        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response(
                $this->makeBadData($this->decodeJson()),
                200,
                ["Headers"]
            )
        ]);

        Livewire::test(Popular::class)
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

        Log::assertLogged("notice", function ($message, $context) {
            return Str::contains(
                $message,
                "Trying to instanciate a game without a name"
            );
        });
    }
}
