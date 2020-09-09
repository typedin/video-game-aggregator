<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MostAnticipatedGamesTest extends TestCase
{
    const FIXTURE = "/../__fixtures__/many-most-anticipated-games.json";

    private function decodeJson()
    {
        $decodedJson = json_decode(
            file_get_contents(__DIR__.self::FIXTURE),
            true
        );
        return $decodedJson;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
