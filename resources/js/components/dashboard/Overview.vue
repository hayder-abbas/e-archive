<script setup lang="ts">
import { OverView } from "@/types";
import { reactive } from "vue";

const props = defineProps<{
  overView: OverView;
}>();

const overView = reactive([
  { id: 1, title: "Archived", total: props.overView.archived },
  { id: 2, title: "Borrow", total: props.overView.borrow },
  { id: 3, title: "Incoming", total: props.overView.incoming },
  { id: 4, title: "Outgoing", total: props.overView.outgoing },
]);
</script>

<template>
  <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-4">
    <div
      v-for="{ id, title, total } in overView"
      :key="id"
      class="relative flex flex-col items-center justify-center gap-4 p-6 overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
    >
      <h2 class="text-xl">{{ $t(`dashboard.${title}`) }}</h2>
      <div class="font-medium text-2xl">{{ total }}</div>
    </div>
  </div>
</template>
