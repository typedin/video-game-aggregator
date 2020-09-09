<div wire:init="load">
  <h2 class="section-title">
    Recently Reviewed
  </h2>
  <div class="mt-8 recently-reviewed-container space-y-12">
    @forelse($games as $game)
      <div class="flex px-6 py-6 bg-gray-800 rounded-lg shadow-md game">
        <div class="relative flex-none">
          <a href="/show/{{ $game->slug }}">
            <img src="{{ $game->getCover()->url }}" alt="game cover" class="w-48 hover:opacity-75 transition ease-in-out duration-150">
          </a>
          <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-900 rounded-full" style="right: -20px; bottom: -20px">
            <div class="flex items-center justify-center h-full text-xs font-semibold">
              {{ $game->getFormattedRating("rating") }}
            </div>
          </div>
        </div>
        <div class="ml-6 lg:ml-12">
          <a href="#" class="block mt-4 text-lg font-semibold leading-tight hover:text-gray-400">
            {{ $game->name }}
          </a>
          <div class="mt-1 text-gray-400">
            {{ $game->getFormattedPlatforms() }}
          </div>
          <p class="hidden mt-6 text-gray-400 lg:block">
            {{ $game->getFormattedSummary() }}
          </p>
        </div>
      </div> <!-- end game -->
    @empty
      @foreach (range(1, 3) as $_)
        <div class="flex px-6 py-6 bg-gray-800 rounded-lg shadow-md game">
          <div class="relative flex-none">
            <div class="w-32 h-40 bg-gray-700 lg:h-56 lg:w-48"></div>
          </div>
          <div class="ml-6 lg:ml-12">
            <div class="inline-block mt-4 text-lg font-semibold leading-tight text-transparent bg-gray-700 rounded-sm">
              A long title goes at this very sport
            </div>
            <div>
              <div class="inline-block mt-2 text-sm font-semibold leading-tight text-transparent bg-gray-700 rounded-sm">
                Xbox, PC, Switch
              </div>
            </div>
            <div class="hidden mt-8 space-y-4 lg:block">
              <span class="inline-block text-sm text-transparent bg-gray-700 rounded">Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</span>
              <span class="inline-block text-sm text-transparent bg-gray-700 rounded">Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</span>
              <span class="inline-block text-sm text-transparent bg-gray-700 rounded">Lorem ipsum dolor sit amet, consetetur sadipscing elitr.</span>
            </div>
          </div>
        </div>
      @endforeach
    @endforelse
  </div>
</div>
