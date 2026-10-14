<script setup lang="ts">
import { Meta } from "@/types";
import { Link } from "@inertiajs/vue3";
import Button from "../ui/button/Button.vue";

defineProps<{ meta: Meta }>();
</script>

<template>
  <div
    v-if="meta.links.length > 3"
    class="flex items-center justify-between mt-8"
  >
    <div class="text-sm">
      {{ $t("global.page :current", { current: String(meta.current_page) }) }}
      {{ $t("global.of :last", { last: String(meta.last_page) }) }} -
      {{ $t("global.(:total) total_items", { total: String(meta.total) }) }}
    </div>
    <div>
      <div class="flex items-center gap-1">
        <Button
          v-for="(link, index) in meta.links"
          :key="index"
          :disabled="!link.url"
          :class="{ 'bg-accent': link.active }"
          as-child
          variant="ghost"
          size="sm"
        >
          <Link :href="link.url || '#'">
            <span v-html="link.label"></span>
          </Link>
        </Button>
      </div>
    </div>
  </div>
</template>
