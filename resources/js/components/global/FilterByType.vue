<script setup lang="ts">
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { AcceptableValue, Direction } from "reka-ui";
import { Box } from "@/types/boxes.js";
import boxes from "@/routes/boxes/index.js";
import documents from "@/routes/documents/index.js";
import Select from "../ui/select/Select.vue";
import SelectContent from "../ui/select/SelectContent.vue";
import SelectItem from "../ui/select/SelectItem.vue";
import SelectTrigger from "../ui/select/SelectTrigger.vue";
import SelectValue from "../ui/select/SelectValue.vue";

const props = defineProps<{
  typeFilter?: string;
  box?: Box;
}>();

const page = usePage();
const component = page.component;
const dir = page.props.dir as Direction;

const selected = ref<string>(props.typeFilter || "all");

function applyFilter(value: AcceptableValue) {
  const filter = typeof value === "string" ? value : "all";
  selected.value = filter;

  router.get(
    component !== "boxes/Show" ? documents.index() : boxes.show(props.box!),
    { typeFilter: value === "all" ? undefined : filter },
    { preserveState: true, preserveScroll: true, replace: true },
  );
}
</script>

<template>
  <Select :model-value="selected" @update:model-value="applyFilter" :dir="dir">
    <SelectTrigger class="w-full">
      <SelectValue />
    </SelectTrigger>
    <SelectContent :dir="dir">
      <SelectItem value="all">{{ $t("global.all") }}</SelectItem>
      <SelectItem value="Incoming">
        {{ $t("document.Incoming") }}
      </SelectItem>
      <SelectItem value="Outgoing">
        {{ $t("document.Outgoing") }}
      </SelectItem>
    </SelectContent>
  </Select>
</template>
