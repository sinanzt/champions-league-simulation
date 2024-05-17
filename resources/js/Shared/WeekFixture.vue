<template>
    <div class="grid gap-y-6">
        <div v-for="(week, weekId) in fixtures" :key="weekId" class="bg-white border border-gray-200 rounded-lg p-5">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                <span v-show="title">{{ title }}</span>
                <span v-show="!title">Week {{ weekId }}</span>
            </h3>

            <div class="grid divide-y">
                <dl v-for="(fixture, index) in week" :key="index" class="grid grid-cols-5 py-2 first:pt-0 last:pb-0">
                    <div class="col-span-2">
                        <Team :team="fixture.data.host" />
                    </div>

                    <span v-if="!fixture.data.playedAt">-</span>
                    <span v-else class="flex items-center">
                        {{ fixture.data.hostGoals }} - {{ fixture.data.guestGoals }}
                    </span>
                    <div class="col-span-2">
                        <Team :team="fixture.data.guest" />
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
import Team from "../Shared/Team.vue";

export default {
    props: {
        title: {
            type: String,
        },
        fixtures: {
            type: Object,
            required: true,
        },
    },
    components: {
        Team,
    },
};
</script>