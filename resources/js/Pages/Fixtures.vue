<template>
    <div>
        <h1 class="font-bold text-lg mb-4">
            Fixtures
        </h1>

        <WeekFixture :fixtures="fixtures" :simulationUid="simulationUid" />

        <div class="mt-6">
            <Button :href="`/${simulationUid}/standings`">
                Check standings
            </Button>
        </div>
    </div>
</template>

<script setup>
import Button from "../Shared/Button.vue";
import WeekFixture from "../Shared/WeekFixture.vue";

let props = defineProps({
    fixtures: Object,
    simulationUid: String,
});
</script>
