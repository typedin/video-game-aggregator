<?php

use Illuminate\Support\Facades\Route;

Route::get("/", "GamesController@index")->name("games.index");
