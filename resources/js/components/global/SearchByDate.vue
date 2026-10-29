<script setup lang="ts">
import { ref } from "vue";
import { Form, usePage } from "@inertiajs/vue3";
import { Box } from "@/types/boxes.js";
import { revokeds } from "@/routes";
import Input from "../ui/input/Input.vue";
import Label from "../ui/label/Label.vue";
import documents from "@/routes/documents";
import Button from "../ui/button/Button.vue";
import boxes from "@/routes/boxes";

const props = defineProps<{
  fromDate: string | null;
  toDate: string | null;
  box?: Box;
}>();

const component = ref(usePage().component);

function submit() {
  switch (component.value) {
    case "documents/index":
      return documents.index();
    case "boxes/index":
      return boxes.index();
    case "boxes/Show":
      return boxes.show(props.box!);
    case "Revokeds":
      return revokeds();
    default:
      return;
  }
}
</script>

<template>
  <Form
    method="get"
    :action="submit()"
    class="space-y-4 md:space-y-0 md:flex md:flex-row md:gap-2"
  >
    <div class="flex flex-col md:flex-row md:justify-start gap-2 w-full">
      <Label>{{ $t("global.from") }}:</Label>
      <Input type="date" name="fromDate" :default-value="fromDate || ''" />
    </div>

    <div class="flex flex-col md:flex-row md:justify-start gap-2 w-full">
      <Label>{{ $t("global.to") }}:</Label>
      <Input type="date" name="toDate" :default-value="toDate || ''" />
    </div>

    <Button
      type="submit"
      variant="secondary"
      class="cursor-pointer w-full md:w-fit"
    >
      Go
    </Button>
  </Form>
</template>
