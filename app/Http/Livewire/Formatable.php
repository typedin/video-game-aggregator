<?php

namespace App\Http\Livewire;

use App\Game\Exceptions\GameException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Trait Formatable
 * @author yourname
 */
trait Formatable
{
    private function format(): Collection
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
