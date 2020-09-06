<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ShowSingleGameTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->withoutExceptionHandling();

        $decodedJson = json_decode(
            file_get_contents(__DIR__."/../__fixtures__/one-full-game.json"),
            true
        );
        Http::fake([
            "https://api-v3.igdb.com/games/" =>
                Http::response([$decodedJson], 200, ["Headers"])
        ]);

        $response = $this->get('/show/tears-of-avia');

        $response->assertStatus(200);
    }
}
