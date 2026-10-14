<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Box, Document } from "@/types";
import { ref } from "vue";
import Card from "../ui/card/Card.vue";
import CardTitle from "../ui/card/CardTitle.vue";
import CardContent from "../ui/card/CardContent.vue";
import CardFooter from "../ui/card/CardFooter.vue";
import Button from "../ui/button/Button.vue";

const props = defineProps<{
  doc: Document;
  box?: Box;
}>();

const boxNumber = props.box
  ? ref(props.box.boxNumber)
  : ref(props.doc.box?.boxNumber);
</script>

<template>
  <Card>
    <CardTitle class="text-center">{{ doc.subject }}</CardTitle>

    <CardContent class="flex flex-col gap-2 text-sm">
      <div class="flex justify-between items-center">
        <div>{{ $t("docs.doc_no") }}:</div>
        <div>{{ doc.number }}</div>
      </div>

      <div class="flex justify-between items-center">
        <div>{{ $t("docs.doc_date") }}:</div>
        <div>{{ doc.date }}</div>
      </div>

      <div class="flex justify-between items-center text-amber-600">
        <div>{{ $t("docs.box_no") }}:</div>
        <div>{{ boxNumber }}</div>
      </div>
    </CardContent>

    <CardFooter class="justify-end">
      <Button size="sm" variant="outline" class="w-1/2">
        <Link href="#">{{ $t("global.view_btn") }}</Link>
      </Button>
    </CardFooter>
  </Card>
</template>
