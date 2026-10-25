<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { Documents } from "@/types";
import DocumentCard from "@/components/document/DocumentCard.vue";
import Paginate from "@/components/global/Paginate.vue";
import { revokeds } from "@/routes";

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

const props = defineProps<{ revokeds: Documents }>();
</script>

<template>
  <Head :title="$t('revokeds.title')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
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
