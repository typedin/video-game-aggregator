<?php

namespace App\Http\Livewire;

use App\Game\Exceptions\GameException;
use App\Game\MostAnticipatedGame;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MostAnticipated extends Component
{
    use Formatable;

    private $unformattedGames;

    public $mostAnticipated = [];

    public function load()
    {
        $today = Carbon::now()->timestamp;
        $inFourMonths = Carbon::now()->addMonths(4)->timestamp;

        $this->unformattedGames = Cache::remember("popular-games", 7, function () use ($today, $inFourMonths) {
            return Http::withHeaders(config("services.igdb"))
            ->withOptions([
                "body" => "
                    fields name, slug, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count; 
                    where platforms = (48, 49, 130, 6)
                    & ( first_release_date >= {$today} 
                    & first_release_date < {$inFourMonths}); 
                    sort popularity desc; 
                    limit 4;
                "
            ])->get("https://api-v3.igdb.com/games/")
            ->json();
        });

        $this->mostAnticipated = $this->format()->toArray();
    }

    private function instanciateGame($unformattedGame)
    {
        return new MostAnticipatedGame($unformattedGame);
    }

    public function render()
    {
        return view('livewire.most-anticipated');
    }
}
