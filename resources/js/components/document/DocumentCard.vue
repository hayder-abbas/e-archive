<script setup lang="ts">
import { Box, Document } from "@/types";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Card from "../ui/card/Card.vue";
import CardTitle from "../ui/card/CardTitle.vue";
import CardContent from "../ui/card/CardContent.vue";
import CardFooter from "../ui/card/CardFooter.vue";
import Button from "../ui/button/Button.vue";
import documents from "@/routes/documents/index.js";

const props = defineProps<{
  document: Document;
  box?: { data: Box };
}>();

const boxNumber = props.box
  ? ref(props.box.data.boxNumber)
  : ref(props.document.box?.boxNumber);
</script>

<template>
  <Card>
    <CardTitle class="text-center">{{ document.subject }}</CardTitle>

    <CardContent class="flex flex-col gap-2 text-sm">
      <div class="flex justify-between items-center">
        <div>{{ $t("document.doc_no") }}:</div>
        <div>{{ document.number }}</div>
      </div>

      <div class="flex justify-between items-center">
        <div>{{ $t("document.doc_date") }}:</div>
        <div>{{ document.date }}</div>
      </div>

      <div class="flex justify-between items-center text-amber-600">
        <div>{{ $t("document.box_no") }}:</div>
        <div>{{ boxNumber }}</div>
      </div>
    </CardContent>

    <CardFooter>
      <!-- View Document -->
      <Button size="icon-sm" variant="outline" class="flex-1 cursor-pointer">
        <Link :href="documents.show(document)">
          {{ $t("global.view_btn") }}
        </Link>
      </Button>
    </CardFooter>
  </Card>
</template>
