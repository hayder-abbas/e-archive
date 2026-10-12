<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Box } from "@/types/index.js";
import Card from "../ui/card/Card.vue";
import CardTitle from "../ui/card/CardTitle.vue";
import CardContent from "../ui/card/CardContent.vue";
import CardFooter from "../ui/card/CardFooter.vue";
import Button from "../ui/button/Button.vue";
import boxes from "@/routes/boxes/index.js";

const props = defineProps<{ box: Box }>();
</script>

<template>
  <Card>
    <!-- Box circle -->
    <div class="flex justify-center items-center">
      <div class="w-14 h-14 rounded-full border-2 border-secondary"></div>
    </div>

    <!-- Box content -->
    <div class="flex flex-col items-center gap-4">
      <CardContent class="text-sm font-semibold">{{ box.boxName }}</CardContent>
      <CardContent class="text-sm font-semibold">
        {{ box.boxNumber }}
      </CardContent>
      <CardContent class="text-sm font-semibold">{{ box.boxDate }}</CardContent>
    </div>

    <CardFooter class="w-full">
      <Button size="sm" variant="outline" class="w-full">
        <Link :href="boxes.show(box)">{{ $t("global.open_btn") }}</Link>
      </Button>
    </CardFooter>
  </Card>
</template>
