<?php

namespace Tests\Feature;

use App\Http\Livewire\RecentlyReviewed;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\BadDataCapable;
use Tests\DecodeJsonCapable;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class RecentlyReviewedGamesTest extends TestCase
{
    use DecodeJsonCapable, BadDataCapable;

    const FIXTURE = "many-recently-reviewed-games.json";

    /**
     * @test
     */
    public function it_shows_recently_reviewed_games()
    {
        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response($this->decodeJson(), 200, ["Headers"])
        ]);

        Livewire::test(RecentlyReviewed::class)
            ->call("load")
            ->assertSee("Factorio")
            ->assertSee("Ghost of Tsushima")
            ->assertSee("Fall Guys: Ultimate Knockout")
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

        Livewire::test(RecentlyReviewed::class)
            ->call("load")
            ->assertSee("Factorio")
            ->assertSee("Ghost of Tsushima")
            ->assertSee("Fall Guys: Ultimate Knockout")
        ;

        Log::assertLogged("notice", function ($message, $context) {
            return Str::contains(
                $message,
                "Trying to instanciate a game without a name"
            );
        });
    }
}
