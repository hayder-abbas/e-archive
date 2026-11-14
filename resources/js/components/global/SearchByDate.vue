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
import { Search } from "@lucide/vue";

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
    class="flex flex-col sm:flex-row gap-2 w-full"
  >
    <div class="flex flex-col sm:flex-row gap-2 w-full">
      <Label>{{ $t("global.from") }}:</Label>
      <Input type="date" name="fromDate" :default-value="fromDate || ''" />
    </div>

    <div class="flex flex-col sm:flex-row gap-2 w-full">
      <Label>{{ $t("global.to") }}:</Label>
      <Input type="date" name="toDate" :default-value="toDate || ''" />
    </div>

    <div class="w-full sm:w-fit flex justify-end">
      <Button
        type="submit"
        variant="secondary"
        class="cursor-pointer w-full sm:w-fit"
      >
        <Search />
        {{ $t("global.search_btn") }}
      </Button>
    </div>
  </Form>
</template>
