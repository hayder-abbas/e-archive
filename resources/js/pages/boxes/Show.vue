<script setup lang="ts">
import { Box, Boxes, Documents, Entities } from "@/types";
import { Form, Head } from "@inertiajs/vue3";
import DocumentCard from "@/components/document/DocumentCard.vue";
import FilterByType from "@/components/global/FilterByType.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Input from "@/components/ui/input/Input.vue";
import boxes from "@/routes/boxes";
import EditBox from "@/components/box/EditBox.vue";
import Paginate from "@/components/global/Paginate.vue";
import AddDocument from "@/components/document/AddDocument.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.boxes",
        href: boxes.index(),
      },
      {
        title: "box.show_box_title",
      },
    ],
  },
});

const props = defineProps<{
  documents: Documents;
  box: { data: Box };
  boxes: Boxes;
  entities: Entities;
  filters: {
    number: string | null;
    fromDate: string | null;
    toDate: string | null;
  };
}>();
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <header>
      <div
        class="flex flex-col md:flex-row items-start md:justify-between md:items-center gap-4"
      >
        <div class="flex items-center gap-4 font-bold w-full">
          <h2>{{ box.data.boxName }}</h2>
          &mdash;
          <p>{{ box.data.boxNumber }}</p>
        </div>

        <div class="flex items-center justify-end gap-4 w-full">
          <!-- Edit Box button -->
          <EditBox :box="props.box" />

          <!-- Add document button -->
          <AddDocument
            :boxes="props.boxes"
            :entities="props.entities"
            :box="props.box"
          />
        </div>
      </div>
    </header>

    <!-- Search -->
    <div class="grid lg:grid-cols-2 gap-4">
      <!-- Search by date -->
      <SearchByDate
        :fromDate="props.filters.fromDate"
        :toDate="props.filters.toDate"
        :box="props.box.data"
      />

      <div class="grid md:grid-cols-2 gap-4 items-end">
        <!-- Search by document number -->
        <Form method="get" :action="boxes.show(props.box.data)">
          <Input
            name="number"
            :default-value="props.filters.number || ''"
            :placeholder="$t('global.search_by_number')"
          />
        </Form>

        <!-- Filter by document type -->
        <FilterByType :box="props.box.data" class="md:flex-1 lg:flex-none" />
      </div>
    </div>

    <!-- Documents -->
    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <div
        class="grid md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-2"
      >
        <DocumentCard
          v-for="doc in props.documents.data"
          :key="doc.id"
          :document="doc"
          :box="box"
        />
      </div>

      <!-- Paginate -->
      <Paginate :meta="props.documents.meta" />
    </div>
  </div>
</template>
