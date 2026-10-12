<script setup lang="ts">
import AddBox from "@/components/box/AddBox.vue";
import BoxCard from "@/components/box/BoxCard.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Input from "@/components/ui/input/Input.vue";
import boxes from "@/routes/boxes";
import { Box } from "@/types/box";
import { Head } from "@inertiajs/vue3";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.boxes",
        href: boxes.index(),
      },
    ],
  },
});

const props = defineProps<{ boxes: { data: Box[] } }>();
</script>

<template>
  <Head :title="$t('sidebar.boxes')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Box Search -->
    <div
      class="flex justify-between gap-4 flex-col lg:flex-row lg:items-center"
    >
      <!-- Search by box date -->
      <SearchByDate />

      <div class="md:flex md:gap-4 space-y-4 md:space-y-0">
        <!-- Search by box number -->
        <Input :placeholder="$t('global.search_by_number')" />

        <!-- Add box button -->
        <AddBox />
      </div>
    </div>

    <!-- Boxes -->
    <div
      class="relative min-h-screen grid md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-4 p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <BoxCard v-for="box in props.boxes.data" :key="box.id" :box="box" />
    </div>
  </div>
</template>
