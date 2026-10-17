<script setup lang="ts">
import { Boxes, Documents, Entities } from "@/types";
import { Head } from "@inertiajs/vue3";
import DocumentCard from "@/components/document/DocumentCard.vue";
import FilterByType from "@/components/global/FilterByType.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Input from "@/components/ui/input/Input.vue";
import Paginate from "@/components/global/Paginate.vue";
import documents from "@/routes/documents";
import AddDocument from "@/components/document/AddDocument.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.documents",
        href: documents.index(),
      },
    ],
  },
});

const props = defineProps<{
  documents: Documents;
  boxes: Boxes;
  entities: Entities;
}>();
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Add new document button -->
    <div class="flex justify-end items-center">
      <AddDocument :boxes="boxes" :entities="entities" />
    </div>

    <!-- Search -->
    <div
      class="flex flex-wrap justify-between gap-4 flex-col lg:flex-row lg:items-center"
    >
      <!-- Search by document date -->
      <SearchByDate />

      <div class="flex gap-4">
        <!-- Search by document number -->
        <Input :placeholder="$t('global.search_by_number')" />

        <!-- Filter by document type -->
        <FilterByType class="md:flex-1 lg:flex-none" />
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
        />
      </div>

      <!-- Paginate -->
      <Paginate :meta="props.documents.meta" />
    </div>
  </div>
</template>
