<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { edit } from "@/routes/appearance";
import { Separator } from "@/components/ui/separator";
import AppearanceTabs from "@/components/AppearanceTabs.vue";
import Heading from "@/components/Heading.vue";
import LocaleSelector from "@/components/global/LocaleSelector.vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "settings.appearance_title",
        href: edit(),
      },
    ],
  },
});
</script>

<template>
  <Head :title="$t('settings.appearance_title')" />

  <h1 class="sr-only">{{ $t("settings.appearance_title") }}</h1>

  <div class="space-y-6">
    <Heading
      variant="small"
      :title="$t('settings.appearance_title')"
      :description="$t('settings.appearance_description')"
    />
    <!-- Appearance -->
    <AppearanceTabs />

    <Separator />

    <!-- Locale Selector -->
    <LocaleSelector />
  </div>
</template>
