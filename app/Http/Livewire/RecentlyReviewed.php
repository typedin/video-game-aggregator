<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class RecentlyReviewed extends Component
{
    public $recentlyReviewed = [];

    public function load()
    {
        $today = Carbon::now()->timestamp;
        $before = Carbon::now()->subMonths(2)->timestamp;

        $this->recentlyReviewed = Cache::remember("popular-games", 7, function () use ($before, $today) {
            return Http::withHeaders(config("services.igdb"))
                ->withOptions([
                    "body" => "
                        fields name, summary, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count; 
                        where platforms = (48, 49, 130, 6)
                        & ( first_release_date >= {$before} 
                        & first_release_date <= {$today}
                        & rating_count > 5); 
                        sort popularity desc; 
                        limit 3;
                    "
                ])->get("https://api-v3.igdb.com/games/")
                ->json();
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
