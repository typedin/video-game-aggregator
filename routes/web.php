<?php

use Illuminate\Support\Facades\Route;

Route::get("/", "GamesController@index")->name("games.index");
Route::get("/show/{slug}", "GamesController@show")->name("games.show");
