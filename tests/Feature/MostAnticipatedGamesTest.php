<?php

namespace Tests\Feature;

use App\Http\Livewire\MostAnticipated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\DecodeJsonCapable;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class MostAnticipatedGamesTest extends TestCase
{
    use DecodeJsonCapable;

    const FIXTURE = "many-most-anticipated-games.json";

    /**
     * @test
     */
    public function it_shows_most_anticipated_games()
    {
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

    private function makeBadData($data)
    {
        $badDataForAGame = [
            "no-name" => "no-name",
            "no-slug" => "no-slug"
        ];

        array_push($data, $badDataForAGame);
        return $data;
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

        Livewire::test(MostAnticipated::class)
            ->call("load")
            ->assertSee("Cyberpunk 2077")
            ->assertSee("Mr. Prepper")
            ->assertSee("Junkyard Simulator")
            ->assertSee("Tears of Avia")
        ;

        Log::assertLogged("notice", function ($message, $context) {
            return Str::contains(
                $message,
                "Trying to instanciate a game without a name"
            );
        });
    }
}
