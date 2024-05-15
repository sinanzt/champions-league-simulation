<div>
    <table class="border-collapse table-auto w-full text-sm">
        
        <tbody class="bg-white">
        @foreach($fixture as $weekId => $weeks)
            <tr>
                <div class="bg-gray-800 text-white font-medium p-4 text-gray-900 dark:text-slate-200 text-left">Week {{ $weekId ?? 'League Ended' }}</div>
            </tr>
            @foreach($weeks as $item)
                <tr>
                    <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">
                        {{ $item->host->name }}
                    </td>
                    <td>
                    @if($item->host_fc_goals)
                  {{ $item->host_fc_goals }} - {{ $item->guest_fc_goals }}
                @else
                  -
                @endif
                    </td>
                    <td class="border-b border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">
                        {{ $item->guest->name }}
                    </td>
                </tr>
            @endforeach

        @endforeach
        </tbody>
    </table>
</div>
