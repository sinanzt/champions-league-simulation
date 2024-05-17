<template>
    <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-4">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">
                    {{ team.name }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        team: {
            required: true,
            type: Object,
            default: {}
        }
    }
};
</script>