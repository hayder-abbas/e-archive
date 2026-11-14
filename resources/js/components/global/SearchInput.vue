<script setup lang="ts">
import { RouteDefinition } from "@/wayfinder/index.js";
import { Form } from "@inertiajs/vue3";
import Input from "../ui/input/Input.vue";

const props = defineProps<{
  action: RouteDefinition<"get">;
  name: string;
  value: string | null;
  placeholder: string | null;
}>();
</script>

<template>
  <Form method="get" :action="props.action" class="w-full">
    <Input
      :name="props.name"
      :defaultValue="props.value || ''"
      :placeholder="props.placeholder"
    />
  </Form>
</template>
