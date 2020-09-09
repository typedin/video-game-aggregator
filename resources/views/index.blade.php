@extends("layouts.app")
@section("content")
  <div class="container px-4 mx-auto">

    <livewire:popular>

    <div class="flex flex-col my-10 lg:flex-row">
      <div class="w-full mr-0 recently-reviewed lg:w-3/4 lg:mr-32">
        <livewire:recently-reviewed>
      </div>
      <div class="mt-12 most-anticipated lg:w-1/4 lg:mt-0">
        <livewire:most-anticipated>

        <livewire:coming-soon>
      </div>
    </div>

  </div>

@endsection
