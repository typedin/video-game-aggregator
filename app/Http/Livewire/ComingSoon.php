<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ComingSoon extends Component
{
    public $comingSoon = [];

    public function load()
    {
        $today = Carbon::now()->timestamp;

        $this->comingSoon = Cache::remember("popular-games", 7, function () use ($today) {
            return Http::withHeaders(config("services.igdb"))
                ->withOptions([
                    "body" => "
                        fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count; 
                        where platforms = (48, 49, 130, 6)
                        & ( first_release_date >= {$today} 
                        & popularity > 5); 
                        sort first_release_date desc; 
                        limit 4;
                    "
                ])->get("https://api-v3.igdb.com/games/")
                  ->json();
        });
    }

    public function render()
    {
        return view('livewire.coming-soon');
    }
}
