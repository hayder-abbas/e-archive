<script setup lang="ts">
import {
  Box,
  Boxes,
  Can,
  Documents,
  Entities,
  TypeFilter,
  Searches,
} from "@/types";
import { Head } from "@inertiajs/vue3";
import DocumentCard from "@/components/document/DocumentCard.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import boxes from "@/routes/boxes";
import EditBox from "@/components/box/EditBox.vue";
import Paginate from "@/components/global/Paginate.vue";
import AddDocument from "@/components/document/AddDocument.vue";
import SearchInput from "@/components/global/SearchInput.vue";

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
  searches: Searches;
  typeFilter: TypeFilter;
  can: Can;
}>();
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <header>
      <div
        class="flex flex-col sm:flex-row items-start md:justify-between md:items-center gap-4"
      >
        <div class="flex items-center gap-4 font-bold w-full">
          <h2>{{ box.data.boxName }}</h2>
          &mdash;
          <p>{{ box.data.boxNumber }}</p>
        </div>

        <div
          v-if="props.can.create && props.can.update"
          class="flex items-center justify-end gap-4 w-full"
        >
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

    <!-- Searchs -->
    <div class="space-y-4">
      <div class="flex flex-col sm:flex-row gap-4 w-full xl:w-1/2">
        <SearchInput
          :action="boxes.show(props.box.data)"
          name="subject"
          :value="props.searches.subject"
          :placeholder="$t('global.search_by_subject')"
        />

        <SearchInput
          :action="boxes.show(props.box.data)"
          name="number"
          :value="props.searches.number"
          :placeholder="$t('global.search_by_number')"
        />
      </div>

      <div class="w-full 2xl:w-1/2">
        <SearchByDate
          :fromDate="props.searches.fromDate"
          :toDate="props.searches.toDate"
          :typeFilter="props.typeFilter"
          :box="props.box.data"
        />
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
