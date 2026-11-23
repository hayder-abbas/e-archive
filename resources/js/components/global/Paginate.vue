<script setup lang="ts">
import { Meta } from "@/types";
import { Link } from "@inertiajs/vue3";
import Button from "../ui/button/Button.vue";

defineProps<{ meta: Meta }>();
</script>

<template>
  <div
    v-if="meta.links.length > 3"
    class="flex flex-col xl:flex-row xl:items-center items-start gap-4 mt-8"
  >
    <div class="w-full text-sm px-6 py-4">
      {{ $t("global.page :current", { current: String(meta.current_page) }) }}
      {{ $t("global.of :last", { last: String(meta.last_page) }) }} -
      {{ $t("global.(:total) total", { total: String(meta.total) }) }}
    </div>

    <div
      class="w-full flex items-center justify-between gap-1 px-6 *:hidden *:first:block *:last:block md:*:block"
    >
      <Button
        v-for="(link, index) in meta.links"
        :key="index"
        :disabled="!link.url"
        as-child
        variant="ghost"
        size="sm"
        :class="{ 'bg-accent': link.active }"
      >
        <Link
          :href="link.url || '#'"
          v-html="link.label"
          class="leading-8 text-sm"
        ></Link>
      </Button>
    </div>
  </div>
</template>
