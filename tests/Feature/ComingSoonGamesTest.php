<?php

namespace Tests\Feature;

use App\Http\Livewire\ComingSoon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\BadDataCapable;
use Tests\DecodeJsonCapable;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class ComingSoonGamesTest extends TestCase
{
    use DecodeJsonCapable, BadDataCapable;

    const FIXTURE = "many-coming-soon-games.json";

    /**
     * @test
     */
    public function it_shows_coming_soon_games()
    {
        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response($this->decodeJson(), 200, ["Headers"])
        ]);

        Livewire::test(ComingSoon::class)
            ->call("load")
            ->assertSee("Factorio")
            ->assertSee("Ghost of Tsushima")
            ->assertSee("Fall Guys: Ultimate Knockout")
            ->assertSee("Destroy All Humans!")
        ;
    }
}
