<script setup lang="ts">
import { Form, Head } from "@inertiajs/vue3";
import { Documents } from "@/types";
import { revokeds } from "@/routes";
import DocumentCard from "@/components/document/DocumentCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Input from "@/components/ui/input/Input.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "revokeds.title",
        href: revokeds(),
      },
    ],
  },
});

const props = defineProps<{
  revokeds: Documents;
  filters: {
    number: string | null;
    fromDate: string | null;
    toDate: string | null;
  };
}>();
</script>

<template>
  <Head :title="$t('revokeds.title')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Search -->
    <div class="flex flex-col md:flex-row md:justify-between gap-4">
      <!-- Search by document date -->
      <SearchByDate
        :fromDate="props.filters.fromDate"
        :toDate="props.filters.toDate"
      />

      <!-- Search by document number -->
      <Form method="get" :action="revokeds()">
        <Input
          name="number"
          :default-value="props.filters.number || ''"
          :placeholder="$t('global.search_by_number')"
        />
      </Form>
    </div>

    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
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
