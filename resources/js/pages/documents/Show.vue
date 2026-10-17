<script setup lang="ts">
import { Boxes, Document, Entities } from "@/types";
import { Head } from "@inertiajs/vue3";
import documents from "@/routes/documents";
import EditDocument from "@/components/document/EditDocument.vue";
import DeleteDocument from "@/components/document/DeleteDocument.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.documents",
        href: documents.index(),
      },
      {
        title: "document.breadcrumb",
      },
    ],
  },
});

const props = defineProps<{
  document: { data: Document };
  boxes: Boxes;
  entities: Entities;
}>();
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex justify-end items-center gap-4">
      <!-- Delete document button -->
      <DeleteDocument :document="props.document.data" />

      <!-- Edit document button -->
      <EditDocument
        :document="props.document.data"
        :boxs="props.boxes"
        :entities="props.entities"
      />
    </div>

    <!-- Documents -->
    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <pre>{{ document }}</pre>
    </div>
  </div>
</template>
