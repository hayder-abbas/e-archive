<script setup lang="ts">
import { Boxes, Document, Entities } from "@/types";
import { Head } from "@inertiajs/vue3";
import { showFile } from "@/actions/App/Http/Controllers/DocumentController";
import documents from "@/routes/documents";
import EditDocument from "@/components/document/EditDocument.vue";
import DeleteDocument from "@/components/document/DeleteDocument.vue";
import Card from "@/components/ui/card/Card.vue";
import Separator from "@/components/ui/separator/Separator.vue";

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
    <div class="flex items-center justify-between">
      <div>
        <h1 class="font-bold text-xl">{{ document.data.subject }}</h1>
      </div>
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
    </div>

    <!-- Documents -->
    <div
      class="relative h-full min-h-screen rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <!-- Display Info -->
      <Card class="flex flex-col py-0">
        <div class="flex gap-6 p-4">
          <div class="flex-1">
            <div class="flex justify-between py-2">
              <div class="font-semibold">
                {{ $t("document.number_label") }}:
              </div>
              <div>{{ document.data.number }}</div>
            </div>
            <Separator />

            <div class="flex justify-between py-2">
              <div class="font-semibold">{{ $t("document.date_label") }}:</div>
              <div>{{ document.data.date }}</div>
            </div>

            <Separator />
            <div class="flex justify-between py-2">
              <div class="font-semibold">{{ $t("document.box_label") }}:</div>
              <div>{{ document.data.box?.boxNumber }}</div>
            </div>
            <Separator />

            <div class="flex justify-between py-2">
              <div class="font-semibold">
                {{ $t("document.entity_label") }}:
              </div>
              <div>{{ document.data.entity?.name }}</div>
            </div>
          </div>
          <div class="flex-1">
            <div class="flex flex-col h-full justify-between">
              <div>
                <div class="font-semibold">
                  {{ $t("document.notes_label") }}:
                </div>
                <div>{{ document.data.notes }}</div>
              </div>
              <div class="flex gap-6">
                <div
                  class="bg-blue-200 text-blue-700 font-bold text-sm rounded-2xl px-4 py-2"
                >
                  {{ $t(`document.${document.data.type}`) }}
                </div>
                <div
                  class="font-bold text-sm rounded-2xl px-4 py-2"
                  :class="
                    document.data.security === 'Secure'
                      ? 'bg-rose-200 text-rose-700'
                      : 'bg-green-200 text-green-700'
                  "
                >
                  {{ $t(`document.${document.data.security}`) }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Display File -->
        <Card class="py-0">
          <object
            type="application/pdf"
            :data="showFile.url(document.data)"
            class="w-full h-dvh rounded-xl"
          >
            <p class="text-center font-semibold py-6">
              {{ $t("document.missing_pdf") }}
            </p>
          </object>
        </Card>
      </Card>
    </div>
  </div>
</template>
