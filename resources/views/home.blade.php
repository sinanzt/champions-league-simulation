<x-layout>
    <div class="grid grid-cols-1 text-lg border-b border-amber-50 mb-2">
        <h1 class="text-gray-950 py-4">Tournament Teams</h1>
    </div>
    <div class="flex items-center mb-2">
        <table class="border-collapse table-auto w-full text-sm">
            <thead class="table-auto">
                <tr>
                    <th class="bg-gray-800 border-b font-medium p-4 text-slate-400 dark:text-slate-200 text-left">Team Name</th>
                </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($teams as $team)
                <tr>
                    <td class="border-b border-slate-200 p-4 text-gray-950">{{ $team->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex items-center p-4">
        <form action="{{route('generateSimulation')}}" method="post">
            @csrf
            <button
                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                Generate Fixtures
            </button>
        </form>
    </div>
</x-layout>
