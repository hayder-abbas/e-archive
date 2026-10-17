<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { trash } from "@/routes";
import { Documents } from "@/types";
import DocumentCard from "@/components/document/DocumentCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import DeleteDocument from "@/components/document/DeleteDocument.vue";
import RestoreDocument from "@/components/document/RestoreDocument.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "trash.title",
        href: trash(),
      },
    ],
  },
});

const props = defineProps<{ documents: Documents }>();
</script>

<template>
  <Head :title="$t('trash.title')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <div
        class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-2"
      >
        <DocumentCard
          v-for="doc in props.documents.data"
          :key="doc.id"
          :document="doc"
        >
          <div class="flex items-center justify-between gap-2 w-full">
            <!-- Force Delete Document -->
            <DeleteDocument :document="doc" :force="true" />

            <!-- Restore Document -->
            <RestoreDocument :document="doc" />
          </div>
        </DocumentCard>
      </div>

      <!-- Paginate -->
      <Paginate :meta="props.documents.meta" />
    </div>
  </div>
</template>
