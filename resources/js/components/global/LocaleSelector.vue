<script setup lang="ts">
import { onMounted, ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { loadLanguageAsync } from "laravel-vue-i18n";
import SetLocaleContruller from "@/actions/App/Http/Controllers/Settings/SetLocaleContruller";
import { AcceptableValue, Direction } from "reka-ui";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../ui/select";

const page = usePage();
const dir = page.props.dir as Direction;
const locale = page.props.locale as string;

onMounted(() => {
  document.documentElement.dir = dir;
});

const selectedLocale = ref(locale);
const locales = [
  { code: "en", label: "English" },
  { code: "ar", label: "العربية" },
];

function selectLocale(code: AcceptableValue) {
  if (typeof code !== "string") return;

  router.visit(SetLocaleContruller.url(), {
    method: "put",
    data: { locale: code },
    onSuccess() {
      loadLanguageAsync(code);
      selectedLocale.value = code;
    },
  });
}
</script>

<template>
  <div class="flex items-center justify-between">
    <h3>{{ $t("settings.language") }}</h3>
    <div>
      <Select
        :model-value="selectedLocale"
        @update:model-value="selectLocale"
        :dir="dir"
      >
        <SelectTrigger class="w-full">
          <SelectValue placeholder="Language" />
        </SelectTrigger>
        <SelectContent :dir="dir">
          <SelectItem v-for="l in locales" :key="l.code" :value="l.code">
            {{ l.label }}
          </SelectItem>
        </SelectContent>
      </Select>
    </div>
  </div>
</template>
