<script setup lang="ts">
import { ref } from "vue";
import { Form, usePage } from "@inertiajs/vue3";
import { Box } from "@/types/boxes.js";
import { revokeds } from "@/routes";
import { Search } from "@lucide/vue";
import { TypeFilter } from "@/types";
import Input from "../ui/input/Input.vue";
import Label from "../ui/label/Label.vue";
import documents from "@/routes/documents";
import Button from "../ui/button/Button.vue";
import boxes from "@/routes/boxes";

const props = defineProps<{
  fromDate: string | null;
  toDate: string | null;
  typeFilter?: TypeFilter;
  box?: Box;
}>();

const component = ref(usePage().component);
const selected = ref(props.typeFilter || "all");
const formRef = ref<HTMLFormElement | null>(null);

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
    ref="formRef"
    :action="submit()"
    class="flex flex-col sm:flex-row gap-4 sm:gap-2 w-full"
  >
    <div class="flex flex-col sm:flex-row gap-2 w-full">
      <div class="flex flex-col sm:flex-row gap-2 w-full">
        <Label>{{ $t("global.from") }}:</Label>
        <Input type="date" name="fromDate" :default-value="fromDate || ''" />
      </div>

      <div class="flex flex-col sm:flex-row gap-2 w-full">
        <Label>{{ $t("global.to") }}:</Label>
        <Input type="date" name="toDate" :default-value="toDate || ''" />
      </div>
    </div>

    <div class="w-full flex justify-end sm:w-fit">
      <Button
        type="submit"
        variant="secondary"
        class="cursor-pointer w-full sm:w-fit"
      >
        <Search />
        <span class="sm:hidden xl:block">{{ $t("global.search_btn") }}</span>
      </Button>
    </div>

    <!-- Filter -->
    <div
      v-if="component !== 'boxes/index'"
      class="flex items-center px-4 py-1 w-full sm:w-40 lg:w-44 xl:w-64 border border-secondary dark:bg-primary-foreground rounded-md"
    >
      <select
        v-model="selected"
        @change="formRef?.submit()"
        name="typeFilter"
        class="w-full text-sm"
      >
        <option value="all">{{ $t("global.all") }}</option>
        <option value="Incoming">{{ $t("document.Incoming") }}</option>
        <option value="Outgoing">{{ $t("document.Outgoing") }}</option>
      </select>
    </div>
  </Form>
</template>
