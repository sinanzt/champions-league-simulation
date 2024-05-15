<x-layout>
  <div class="container mx-auto">
    <h1 class="text-3xl font-semibold text-center mb-8">Generated Fixtures</h1>
    <div class="grid grid-cols-3 gap-4">
      @foreach($fixtures as $weekId => $week)
        <div class="bg-white rounded-lg shadow-md">
          <h2 class="bg-gray-800 p-1 text-white text-lg font-bold mb-2 text-center">Week {{ $weekId }}</h2>
          @foreach($week as $fixture)
            <div class="flex justify-between items-center p-2">
              <span class="flex-1 text-right mr-1">{{ $fixture->host->name }}</span>
              <span class="flex items-center text-center">
                @if($fixture->host_fc_goals)
                  {{ $fixture->host_fc_goals }} - {{ $fixture->guest_fc_goals }}
                @else
                  -
                @endif
              </span>
              <span class="flex-1 ml-1">{{ $fixture->guest->name }}</span>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
    <div class="text-center mt-8">
      <a class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" href ="{{ route('standings', ['simulation' => $simulationUid]) }}">Start Simulation</a>
    </div>
  </div>
</x-layout>