<script setup lang="ts">
import { Boxes, Document, Documents, Entities } from "@/types";
import { Head } from "@inertiajs/vue3";
import documents from "@/routes/documents";
import EditDocument from "@/components/document/EditDocument.vue";
import DeleteDocument from "@/components/document/DeleteDocument.vue";
import Card from "@/components/ui/card/Card.vue";
import Separator from "@/components/ui/separator/Separator.vue";
import DocumentCard from "@/components/document/DocumentCard.vue";
import ViewFile from "@/components/document/ViewFile.vue";
import AddDocument from "@/components/document/AddDocument.vue";

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
</script>

<template>
  <Head :title="$t('sidebar.documents')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
      <div>
        <h1 class="font-bold text-xl">{{ document.data.subject }}</h1>
      </div>

      <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full grid grid-cols-3 md:w-fit justify-end gap-4">
          <!-- Delete document button -->
          <DeleteDocument :document="props.document.data" />

          <!-- Edit document button -->
          <EditDocument
            :document="props.document.data"
            :boxes="props.boxes"
            :entities="props.entities"
          />

          <!-- Open The File -->
          <ViewFile :document="props.document.data" />
        </div>

        <!-- Add new Document -->
        <AddDocument
          :document="props.document.data"
          :boxes="props.boxes"
          :entities="props.entities"
        />
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
            <div class="flex justify-between py-2">
              <div>{{ $t("document.number_label") }}:</div>
              <div>{{ document.data.number }}</div>
            </div>
            <Separator />

            <div class="flex justify-between py-2">
              <div>{{ $t("document.date_label") }}:</div>
              <div>{{ document.data.date }}</div>
            </div>
            <Separator />

            <div class="flex justify-between py-2">
              <div>{{ $t("document.box_label") }}:</div>
              <div>{{ document.data.box?.boxNumber }}</div>
            </div>
            <Separator />

            <div class="flex justify-between py-2">
              <div>{{ $t("document.entity_label") }}:</div>
              <div>{{ document.data.entity?.name }}</div>
            </div>
            <Separator />

            <div class="flex justify-between py-2">
              <div>{{ $t("document.belongs_to_label") }}:</div>
              <div>{{ document.data.belongsTo }}</div>
            </div>
          </div>
          <Separator class="md:hidden" />

          <div class="flex-1">
            <div class="flex flex-col h-full justify-between">
              <div class="py-3 md:py-0">
                <div>{{ $t("document.notes_label") }}:</div>
                <div class="ps-4 text-sm">{{ document.data.notes }}</div>
              </div>
              <div class="flex gap-6">
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
