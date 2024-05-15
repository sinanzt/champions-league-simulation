<div>
    <table class="border-collapse table-auto w-full text-sm">
        <thead class="table-auto">
            <tr class="bg-gray-800 p-1 text-white">
                <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200 text-left">Team</th>
                <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200 text-left">P</th>
                <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200 text-left">W</th>
                <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200 text-left">D</th>
                <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200 text-left">L</th>
                <th class="border-b dark:border-slate-600 font-medium p-4 text-slate-400 dark:text-slate-200 text-left">GD</th>
            </tr>
        </thead>
        <tbody class="bg-white">
        @foreach($standings as $item)
            <tr>
                <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ $item->team->name }}</td>
                <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ $item->points }}</td>
                <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ $item->won }}</td>
                <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ $item->draw }}</td>
                <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ $item->lost }}</td>
                <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ $item->goal_difference }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
