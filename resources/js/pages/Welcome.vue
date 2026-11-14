<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { dashboard } from "@/routes";
import Card from "@/components/ui/card/Card.vue";
import CardHeader from "@/components/ui/card/CardHeader.vue";
import CardTitle from "@/components/ui/card/CardTitle.vue";
import CardDescription from "@/components/ui/card/CardDescription.vue";
import CardContent from "@/components/ui/card/CardContent.vue";
import Button from "@/components/ui/button/Button.vue";
</script>

<template>
  <Head :title="$t('home.title')" />

  <div
    class="flex min-h-screen items-center justify-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a]"
  >
    <Card class="w-full max-w-2xl">
      <CardHeader class="text-center">
        <CardTitle class="text-4xl">{{ $t("home.title") }}</CardTitle>
        <CardDescription class="text-base lg:text-lg xl:text-xl">
          {{ $t("home.description") }}
        </CardDescription>
      </CardHeader>

      <CardContent class="flex justify-center">
        <Button>
          <Link :href="dashboard()" class="w-full">
            {{ $t("home.accessing_btn") }}
          </Link>
        </Button>
      </CardContent>
    </Card>
  </div>
</template>
