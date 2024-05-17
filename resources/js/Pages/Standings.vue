<template>
    <div class="flex items-center justify-between mb-4">
        <h1 class="font-bold text-lg">
            Standings
        </h1>

        <span class="relative z-0 inline-flex rounded-md">
            <Button :href="`/${simulationUid}/play-all`" method="post" as="button">
                Play all
            </Button>

            <Button :href="`/${simulationUid}/play-week`" method="post" as="button">
                Next Week
            </Button>

            <Button :href="`/${simulationUid}/reset`" method="post" as="button">
                Reset
            </Button>

            <Button :href="`/${simulationUid}/fixtures`">
                See all fixtures
            </Button>
        </span>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-1">
            <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Team
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                P
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                W
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                D
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                L
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                GD
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(standing, standingIndex) in standings.data" :key="standingIndex"
                            :class="standingIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                            <td class="p-4 whitespace-nowrap">
                                <Team :team="standing.team" />
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                                {{ standing.points }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                                {{ standing.won }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                                {{ standing.draw }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                                {{ standing.lost }}
                            </td>
                            <td class="p-4 whitespace-nowrap text-sm text-gray-500">
                                {{ standing.goal_difference }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-span-1">
            <WeekFixture :fixtures="nextFixture" :simulationUid="simulationUid"
                :title="`Next week (Week ${Object.keys(nextFixture)[0]})`" />

            <div v-show="nextFixture.length == 0" class="grid gap-y-6">
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Simulation completed
                    </h3>
                </div>
            </div>

            <WeekFixture :fixtures="lastPlayedFixture" :simulationUid="simulationUid" title="Last week" class="mt-4" />
        </div>
    </div>
</template>

<script>
import Button from "../Shared/Button.vue";
import Team from "../Shared/Team.vue";
import WeekFixture from "../Shared/WeekFixture.vue";

export default {
    props: {
        standings: {
            type: Object,
            required: true,
        },
        nextFixture: {
            type: Object,
            required: true,
        },
        lastPlayedFixture: {
            type: Object,
            required: true,
        },
        simulationUid: {
            type: String,
            required: true,
        },
    },
    components: {
        Team,
        Button,
        WeekFixture
    }
};
</script>