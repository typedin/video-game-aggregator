<div wire:init="load">
  <h2 class="font-semibold tracking-wide text-blue-500 uppercase">
    Popular Games
  </h2>
  <div class="pb-16 text-sm border-b border-gray-800 popular-games grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12">
    @forelse($popularGames as $game)
      <div class="mt-8 game">
        <div class="relative inline-block">
          <a href="#">
            <img src="{{ $game->coverUrl }}" alt="Valorant" class="hover:opacity-75 transition ease-in-out duration-150"/>
          </a>
            <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full" style="right: -20px; bottom: -20px;">
              <div class="flex items-center justify-center h-full text-xs font-semibold">
                {{ $game->rating }}
              </div>
            </div>
        </div>
        <a class="block mt-8 text-base font-semibold leading-tight hover:text-gray-400" href="#">
          {{ $game->name }}
        </a>
        <div class="mt-1 text-gray-400">
          {{ $game->platforms }}
        </div>
      </div>
    @empty
      @foreach (range(1, 12) as $_)
      <div class="mt-8 game">
        <div class="relative inline-block">
          <div class="h-56 bg-gray-800 w-44"></div>
        </div>
        <div class="block mt-4 text-sm font-semibold leading-tight text-transparent bg-gray-700 rounded-sm">
          Title goes here
        </div>
        <div class="inline-block mt-2 text-sm font-semibold leading-tight text-transparent bg-gray-700 rounded-sm">
          PS4, PC, SWITCH
        </div>
      </div>
      @endforeach
    @endforelse
  </div>
</div>
