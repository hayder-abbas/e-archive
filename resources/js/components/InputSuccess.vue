<script setup lang="ts">
defineProps<{
  message?: string;
}>();
</script>

<template>
  <div>
    <p class="text-sm text-green-600 dark:text-green-500">
      {{ message }}
    </p>
  </div>
</template>
