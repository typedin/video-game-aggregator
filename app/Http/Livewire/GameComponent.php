<?php

namespace App\Http\Livewire;

use App\Game\GameInterface;
use Illuminate\Support\Facades\Log;
use App\Game\Exceptions\GameException;
use Illuminate\Support\Collection;
use Livewire\Component;

abstract class GameComponent extends Component
{
    public $games = [];
    protected $unformattedGames;

    abstract protected function getData();

    abstract protected function instanciateGame($unformattedGame);

    public function load()
    {
        $this->unformattedGames = $this->getData();

        $this->games = $this->format()->toArray();
    }

    protected function format(): Collection
    {
        return collect($this->unformattedGames)
            ->map(function ($unformattedGame) {
                try {
                    return $this->instanciateGame($unformattedGame);
                } catch (GameException $e) {
                    Log::notice($e);
                }
            })->filter();
    }
}
