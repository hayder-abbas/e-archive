<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { dashboard } from "@/routes";
import { Documents, OverView } from "@/types";
import Overview from "@/components/dashboard/Overview.vue";
import DocumentCard from "@/components/document/DocumentCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchInput from "@/components/global/SearchInput.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.dashboard",
        href: dashboard(),
      },
    ],
  },
});

const props = defineProps<{
  documents: Documents;
  overView: OverView;
  keyWord: string | null;
}>();
</script>

<template>
  <Head :title="$t('sidebar.dashboard')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-6">
    <!-- Overview -->
    <Overview :overView="props.overView" />

    <div
      class="relative min-h-screen flex-1 p-4 space-y-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
    >
      <!-- Search Form -->
      <div>
        <SearchInput
          :action="dashboard()"
          name="keyWord"
          :value="props.keyWord"
          :placeholder="$t('dashboard.search_by_keyword')"
          class="max-w-3xl mx-auto"
        />
      </div>

      <!-- Result -->
      <div
        v-if="!!props.keyWord"
        class="relative min-h-screen md:min-h-min dark:border-sidebar-border overflow-hidden"
      >
        <div
          class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6 gap-4"
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
  </div>
</template>
