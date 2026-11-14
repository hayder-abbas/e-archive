<script setup lang="ts">
import AddBox from "@/components/box/AddBox.vue";
import BoxCard from "@/components/box/BoxCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import SearchInput from "@/components/global/SearchInput.vue";
import boxes from "@/routes/boxes";
import { Boxes, Can, Filters } from "@/types";
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

const props = defineProps<{
  boxes: Boxes;
  filters: Filters;
  can: Can;
}>();
</script>

<template>
  <Head :title="$t('sidebar.boxes')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Search -->
    <div class="flex flex-col xl:flex-row-reverse gap-4">
      <div
        class="flex flex-col-reverse sm:flex-row gap-4 w-full xl:w-2/5 2xl:w-1/2"
      >
        <SearchInput
          :action="boxes.index()"
          name="number"
          :value="props.filters.number"
          :placeholder="$t('global.search_by_number')"
        />

        <!-- Add box button -->
        <div v-if="props.can.create" class="flex justify-end w-full">
          <AddBox />
        </div>
      </div>

      <SearchByDate
        :fromDate="props.filters.fromDate"
        :toDate="props.filters.toDate"
        class="xl:w-3/5 2xl:w-1/2"
      />
    </div>

    <!-- Boxes -->
    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <div class="grid gap-4 md:grid-cols-4 lg:grid-cols-5 2xl:grid-cols-6">
        <BoxCard v-for="box in props.boxes.data" :key="box.id" :box="box" />
      </div>

      <!-- Paginate -->
      <Paginate :meta="props.boxes.meta" />
    </div>
  </div>
</template>
