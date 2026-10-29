<script setup lang="ts">
import AddBox from "@/components/box/AddBox.vue";
import BoxCard from "@/components/box/BoxCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Input from "@/components/ui/input/Input.vue";
import boxes from "@/routes/boxes";
import { Boxes } from "@/types";
import { Form, Head } from "@inertiajs/vue3";

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
  filters: {
    number: string;
    fromDate: string;
    toDate: string;
  };
}>();
</script>

<template>
  <Head :title="$t('sidebar.boxes')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Search -->
    <div class="grid lg:grid-cols-2 gap-4">
      <!-- Search by box date -->
      <SearchByDate
        :fromDate="props.filters.fromDate"
        :toDate="props.filters.toDate"
      />

      <div class="grid md:grid-cols-2 gap-4">
        <!-- Search by box number -->
        <Form method="get" :action="boxes.index()">
          <Input
            name="number"
            :default-value="props.filters.number || ''"
            :placeholder="$t('global.search_by_number')"
          />
        </Form>

        <!-- Add box button -->
        <div class="flex justify-end items-center">
          <AddBox />
        </div>
      </div>
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
