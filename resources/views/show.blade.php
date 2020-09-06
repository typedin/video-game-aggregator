@extends('layouts.app')

@section('content')
    <div class="container px-4 mx-auto">
        <div class="flex flex-col pb-12 border-b border-gray-800 game-details lg:flex-row">
            <div class="flex-none">
                <img src="{{ $game->cover->url }}" alt="cover">
            </div>
            <div class="lg:ml-12 xl:mr-64">
                <h2 class="mt-1 text-4xl font-semibold leading-tight">
                    {{ $game->getName() }}
                </h2>

                <div class="text-gray-400">
                    <span>{{ $game->genres }}</span>
                    &middot;
                    <span>{{ $game->companies }}</span>
                    &middot;
                    <span>{{ $game->getPlatforms() }}</span>
                </div>

                <div class="flex flex-wrap items-center mt-8">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-full">
                            <div class="flex items-center justify-center h-full text-xs font-semibold">
                                {{ $game->memberRating }}
                            </div>
                        </div>
                        <div class="flex flex-col ml-4 text-xs">
                            <span>
                                Member
                            </span>
                            <span>
                                Score
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center ml-12">
                        <div class="w-16 h-16 bg-gray-800 rounded-full">
                            <div class="flex items-center justify-center h-full text-xs font-semibold">
                                {{ $game->rating }}
                            </div>
                        </div>
                        <div class="flex flex-col ml-4 text-xs">
                            <span>
                                Critic
                            </span>
                            <span>
                                Score
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center mt-4 space-x-4 sm:mt-0 sm:ml-12">
                        @foreach($game->socials as $social)
                            <div class="flex items-center justify-center w-8 h-8 bg-gray-800 rounded-full">
                                <a href="{{ $social->url }}" class="hover:text-gray-400">
                                    @include("svg.".$social->name)
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <p class="mt-12">
                    {{ $game->summary }}
                </p>

                @if( $game->trailers->count() )
                    <div class="mt-12">
                        <a
                            href={{ $game->trailers->first()  }}
                            class="flex inline-flex px-4 py-4 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600 transition ease-in-out duration-150">
                            <svg class="w-6 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-2">
                                Play Trailer
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="pb-12 mt-8 border-b border-gray-800 images-container">
            <h2 class="font-semibold tracking-wide text-blue-500 uppercase">
                Images
            </h2>

            <div class="mt-8 grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach ($game->screenshots as $screenshot)
                    <div class="flex justify-center">
                        <a href="{{ $screenshot['huge'] }}">
                            <img
                                src="{{ $screenshot['big'] }}"
                                alt="screenshot"
                                class="hover:opacity-75 transition ease-in-out duration-150"
                            >
                        </a>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="mt-8 similar-games-container">
            <h2 class="font-semibold tracking-wide text-blue-500 uppercase">
                Similar Games
            </h2>
            <div class="text-sm similar-games grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12">
                @foreach ($game->similarGames as $similarGame)
                    <div class="mt-8 game">
                        <div class="relative inline-block">
                            <a href="{{ $similarGame->getSlug()}}">
                                <img
                                    src="{{ $similarGame->cover->url }}"
                                    alt="game cover"
                                    class="hover:opacity-75 transition ease-in-out duration-150"
                                >
                            </a>
                            <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full" style="right: -20px; bottom: -20px">
                                <div class="flex items-center justify-center h-full text-xs font-semibold">
                                    {{ $similarGame->rating }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ $similarGame->getSlug() }}" class="block mt-8 text-base font-semibold leading-tight hover:text-gray-400">
                            {{ $similarGame->getName()}}
                        </a>
                        <div class="mt-1 text-gray-400">
                            {{ $similarGame->platforms }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
