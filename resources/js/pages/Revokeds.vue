<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Documents, Filters } from "@/types";
import { revokeds } from "@/routes";
import DocumentCard from "@/components/document/DocumentCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import SearchInput from "@/components/global/SearchInput.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "document.revokeds_title",
        href: revokeds(),
      },
    ],
  },
});

const props = defineProps<{
  revokeds: Documents;
  filters: Filters;
}>();
</script>

<template>
  <Head :title="$t('document.revokeds_title')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Search -->
    <div class="flex flex-wrap lg:flex-row gap-4">
      <div class="w-full max-w-3xl">
        <SearchByDate
          :fromDate="props.filters.fromDate"
          :toDate="props.filters.toDate"
        />
      </div>

      <div class="flex flex-col md:flex-row gap-4 w-full max-w-3xl">
        <SearchInput
          :action="revokeds()"
          name="subject"
          :value="props.filters.subject"
          :placeholder="$t('global.search_by_subject')"
        />

        <SearchInput
          :action="revokeds()"
          name="number"
          :value="props.filters.number"
          :placeholder="$t('global.search_by_number')"
        />
      </div>
    </div>

    <div
      class="relative min-h-screen h-full p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <div
        class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 gap-2"
      >
        <DocumentCard
          v-for="revoked in props.revokeds.data"
          :key="revoked.id"
          :document="revoked"
        />
      </div>

      <!-- Paginate -->
      <Paginate :meta="props.revokeds.meta" />
    </div>
  </div>
</template>
