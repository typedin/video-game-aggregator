<?php

namespace App\Http\Livewire;

use App\Game\PopularGame;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Popular extends Component
{
    use Formatable;

    private $unformattedGames;

    public $popularGames = [];

    public function load()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;

        $this->unformattedGames = Cache::remember("popular-games", 60, function () use ($before, $after) {
            return Http::withHeaders(config("services.igdb"))
                ->withOptions([
                    "body" => "
                        fields name, slug, cover.url, first_release_date, popularity, platforms.abbreviation, rating; 
                        where platforms = (48, 49, 130, 6)
                        & ( first_release_date >= {$before} 
                        & first_release_date <= {$after}
                        ); 
                        sort popularity desc; 
                        limit 12;
                    "
                ])->get("https://api-v3.igdb.com/games/")
                ->json();
        });

        $this->popularGames = $this->format()->toArray();
    }

    private function instanciateGame($unformattedGame)
    {
        return new PopularGame($unformattedGame);
    }

    public function render()
    {
        return view('livewire.popular-games');
    }
}
