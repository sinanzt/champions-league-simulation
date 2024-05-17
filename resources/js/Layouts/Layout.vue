<template>
  <section class="p-2 bg-gray-200">
    <header class="max-w-5xl mx-auto">
      <div class="flex items-center justify-end">
        <Button :href="`/`">
              Home
          </Button>
      </div>
    </header>
  </section>

  <section class="p-6">
    <div class="max-w-5xl mx-auto">
      <slot />
    </div>
  </section>
</template>


<script>
import Button from '../Shared/Button.vue';

export default {
    components: {
        Button
    },
};
</script>