<script setup lang="ts">
import { computed } from "vue";
import { Head } from "@inertiajs/vue3";
import { Boxes, Document, Documents, Entities } from "@/types";
import documents from "@/routes/documents";
import EditDocument from "@/components/document/EditDocument.vue";
import RevokeDocument from "@/components/document/RevokeDocument.vue";
import Card from "@/components/ui/card/Card.vue";
import Separator from "@/components/ui/separator/Separator.vue";
import DocumentCard from "@/components/document/DocumentCard.vue";
import ViewFile from "@/components/document/ViewFile.vue";
import AddDocument from "@/components/document/AddDocument.vue";
import ReinstateDocument from "@/components/document/ReinstateDocument.vue";

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
  followers: Documents;
  boxes: Boxes;
  entities: Entities;
}>();

const revoked = computed(() => props.document.data.revokedAt);
const formatRevoked = computed(
  () => new Date(revoked.value).toLocaleString("en-GB").split(",")[0],
);
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div>
        <h1 class="font-bold text-lg">{{ document.data.subject }}</h1>
      </div>

      <div class="flex flex-col items-center md:flex-row gap-4">
        <div class="w-full grid grid-cols-2 md:w-fit gap-4">
          <!-- Revoke button -->
          <RevokeDocument v-if="!revoked" :document="props.document.data" />

          <!-- Reinstate button -->
          <ReinstateDocument v-else :document="props.document.data" />

          <!-- Display File -->
          <ViewFile :document="props.document.data" />
        </div>

        <div v-if="!revoked" class="w-full grid grid-cols-2 md:w-fit gap-4">
          <!-- Edit document button -->
          <EditDocument
            :document="props.document.data"
            :boxes="props.boxes"
            :entities="props.entities"
          />

          <!-- Add new Document -->
          <AddDocument
            :document="props.document.data"
            :boxes="props.boxes"
            :entities="props.entities"
          />
        </div>
      </div>
    </div>

    <!-- Documents -->
    <div
      class="relative h-full min-h-screen rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <!-- Display Info -->
      <Card class="flex flex-col h-full">
        <div class="flex flex-col md:flex-row md:gap-6 px-6 mb-6">
          <div class="flex-1">
            <div class="flex justify-between gap-4 py-2">
              <div>{{ $t("document.number_label") }}:</div>
              <div>{{ document.data.number }}</div>
            </div>
            <Separator />

            <div class="flex justify-between gap-4 py-2">
              <div>{{ $t("document.date_label") }}:</div>
              <div>{{ document.data.date }}</div>
            </div>
            <Separator />

            <div class="flex justify-between gap-4 py-2">
              <div>{{ $t("document.box_label") }}:</div>
              <div>{{ document.data.box?.boxNumber }}</div>
            </div>
            <Separator />

            <div class="flex justify-between gap-4 py-2">
              <div>{{ $t("document.entity_label") }}:</div>
              <div>{{ document.data.entity?.name }}</div>
            </div>
            <Separator />

            <div class="flex justify-between gap-4 py-2">
              <div>{{ $t("document.belongs_to_label") }}:</div>
              <div>
                {{ document.data.belongsTo ?? $t("document.belongs_to_non") }}
              </div>
            </div>
          </div>
          <Separator class="md:hidden" />

          <div class="flex-1">
            <div class="flex flex-col h-full justify-between">
              <div class="py-3 md:py-0">
                <div>{{ $t("document.notes_label") }}:</div>
                <div class="ps-4 text-sm">{{ document.data.notes }}</div>
              </div>
              <div v-if="!revoked" class="flex gap-6">
                <div
                  class="bg-indigo-100 text-indigo-600 font-bold text-sm rounded-2xl px-4 py-2"
                >
                  {{ $t(`document.${document.data.type}`) }}
                </div>
                <div
                  class="font-bold text-sm rounded-2xl px-4 py-2"
                  :class="
                    document.data.security === 'Secure'
                      ? 'bg-rose-100 text-rose-600'
                      : 'bg-lime-100 text-lime-600'
                  "
                >
                  {{ $t(`document.${document.data.security}`) }}
                </div>
              </div>
              <div v-else>
                <div
                  class="bg-rose-100 text-rose-600 font-bold rounded-2xl px-4 py-2 flex justify-between items-center"
                >
                  <span>{{ $t("document.revoked_at") }}:</span>
                  <span>{{ formatRevoked }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Followers -->
        <div
          class="px-6 grid md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3"
        >
          <DocumentCard
            v-for="doc in props.followers.data"
            :key="doc.id"
            :document="doc"
          />
        </div>
      </Card>
    </div>
  </div>
</template>
