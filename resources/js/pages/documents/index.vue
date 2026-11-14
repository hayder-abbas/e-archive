<script setup lang="ts">
import { Boxes, Can, Documents, Entities, Filters } from "@/types";
import { Head } from "@inertiajs/vue3";
import DocumentCard from "@/components/document/DocumentCard.vue";
import FilterByType from "@/components/global/FilterByType.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Paginate from "@/components/global/Paginate.vue";
import documents from "@/routes/documents";
import AddDocument from "@/components/document/AddDocument.vue";
import SearchInput from "@/components/global/SearchInput.vue";

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
  filters: Filters;
  can: Can;
}>();
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Searchs -->
    <div class="space-y-4">
      <div class="flex flex-col-reverse lg:flex-row gap-4">
        <SearchByDate
          :fromDate="props.filters.fromDate"
          :toDate="props.filters.toDate"
          class="w-full lg:w-2/3 2xl:w-3/6"
        />

        <!-- Add new document button -->
        <div class="flex justify-end w-full lg:w-1/3 2xl:w-3/6">
          <AddDocument
            v-if="props.can.create"
            :boxes="boxes"
            :entities="entities"
          />
        </div>
      </div>

      <div class="flex flex-col md:flex-row 2xl:justify-between gap-4">
        <div class="flex flex-col md:flex-row xl:w-2/3 2xl:w-1/2 gap-4 w-full">
          <SearchInput
            :action="documents.index()"
            name="subject"
            :value="props.filters.subject"
            :placeholder="$t('global.search_by_subject')"
          />

          <SearchInput
            :action="documents.index()"
            name="number"
            :value="props.filters.number"
            :placeholder="$t('global.search_by_number')"
          />
        </div>

        <!-- Filters -->
        <div class="w-full md:w-1/3 flex justify-end">
          <div class="w-full xl:w-36">
            <FilterByType />
          </div>
        </div>
      </div>
    </div>

    <!-- Documents -->
    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <div
        class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 gap-2"
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
