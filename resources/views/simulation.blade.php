<x-layout>
    <div class="grid grid-cols-1 text-2xl text-center border-b border-amber-50 mb-4">
        <h1 class="text-gray-900 py-4">Simulation</h1>
    </div>
    <div class="grid grid-cols-3 gap-3 m-4">
        <x-standings :standings="$standings"/>
        @if(count($lastPlayedFixture))
            <x-week :fixture="$lastPlayedFixture"/>
        @endif
        <x-week :fixture="$nextFixture"/>
    </div>

    <div class="grid grid-cols-3 gap-3">
        <div class="items-center">
            <form action="{{route('simulation.playAll', ['simulation' => $simulationUid])}}" method="POST" class="flex items-center justify-center my-6">
                @csrf
                <button type="submit"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Play All Weeks
                </button>
            </form>
        </div>
        <div class="items-center">
            <form action="{{route('simulation.playWeek', ['simulation' => $simulationUid])}}" method="POST" class="flex items-center justify-center my-6">
                @csrf
                <button type="submit"
                        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                    Simulate Next Week
                </button>
            </form>
        </div>
        <div class="items-center">
            <form action="{{route('simulation.reset', ['simulation' => $simulationUid])}}" method="POST" class="flex items-center justify-center my-6">
                @csrf
                <button type="submit"
                        class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Reset Simulation
                </button>
            </form>
        </div>
    </div>
</x-layout>
