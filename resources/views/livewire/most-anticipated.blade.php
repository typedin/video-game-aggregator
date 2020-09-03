<div wire:init="load">
  <h2 class="font-semibold tracking-wide text-blue-500 uppercase">
    Most Anticipated
  </h2>
  @forelse($mostAnticipated as $game)
    <div class="mt-8 most-anticipated-container space-y-10">
      <div class="flex game">
        <a href="#">
          <img src="{{ $game->coverUrl }}"
          alt="game cover"
          class="w-16 hover:opacity-75 transition ease-in-out duration-150"
          >
          </a>
        <div class="ml-4">
          <a href="#" class="hover:text-gray-300">{{ $game->name }}</a>
          <div class="mt-1 text-sm text-gray-400">
            {{ $game->releaseDate }}
            </div>
          </div>
        </div>
      </div>
    @empty
      @foreach (range(1, 4) as $_)
        <div class="mt-8 most-anticipated-container space-y-10">
          <div class="flex game">
            <div class="flex-none w-16 h-20 bg-gray-800"></div>
            <div class="ml-4">
              <div class="leading-tight text-transparent bg-gray-700 rounded">
                Title goes here today
              </div>
              <div class="inline-block mt-2 leading-tight text-transparent bg-gray-700 rounded">
                Sept 14, 2020
              </div>
            </div>
          </div>
        </div>
        @endforeach
      @endforelse
</div>
