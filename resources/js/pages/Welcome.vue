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
  <Head :title="$t('home.title')">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>
  <div
    class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
  >
    <main
      class="w-full flex justify-center items-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
    >
      <Card class="w-full">
        <CardHeader class="text-center">
          <CardTitle class="text-4xl">{{ $t("home.title") }}</CardTitle>
          <CardDescription class="text-lg">
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
    </main>
  </div>
</template>
