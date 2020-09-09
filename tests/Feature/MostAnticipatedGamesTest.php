<?php

namespace Tests\Feature;

use App\Http\Livewire\MostAnticipated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\DecodeJsonCapable;
use Tests\TestCase;

class MostAnticipatedGamesTest extends TestCase
{
    use DecodeJsonCapable;

    const FIXTURE = "many-most-anticipated-games.json";

    /**
     * @test
     */
    public function it_shows_most_anticipated_games()
    {
        Livewire::test(MostAnticipated::class)
            ->assertSet("mostAnticipated", []);

        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response(
                $this->decodeJson(),
                200,
                ["Headers"]
            )
        ]);

        Livewire::test(MostAnticipated::class)
            ->call("load")
            ->assertSee("Cyberpunk 2077")
            ->assertSee("Mr. Prepper")
            ->assertSee("Junkyard Simulator")
            ->assertSee("Tears of Avia")
        ;
    }

    /**
     * @test
     */
    public function it_logs_error_when_wrong_data_has_been_retreived()
    {
        Livewire::test(MostAnticipated::class)
            ->assertSet("mostAnticipated", []);

        Http::fake([
            "https://api-v3.igdb.com/games/" => Http::response(
                $this->decodeJson(),
                200,
                ["Headers"]
            )
        ]);

        Livewire::test(MostAnticipated::class)
            ->call("load")
            ->assertSee("Cyberpunk 2077")
            ->assertSee("Mr. Prepper")
            ->assertSee("Junkyard Simulator")
            ->assertSee("Tears of Avia")
        ;
    }
}
