<script setup lang="ts">
import { Document } from "@/types";
import { BookOpen } from "@lucide/vue";
import { showFile } from "@/actions/App/Http/Controllers/DocumentController.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";

const props = defineProps<{ document: Document }>();
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button size="sm" variant="outline" class="w-full cursor-pointer">
        <BookOpen />
        <span>{{ $t("global.view_file") }}</span>
      </Button>
    </DialogTrigger>

    <DialogContent
      class="h-[90%] w-full md:min-w-[90%] lg:min-w-[80%] xl:min-w-[70%] 2xl:min-w-[60%] p-0 pt-10 overflow-auto"
    >
      <object
        type="application/pdf"
        :data="showFile.url(document)"
        class="w-full h-dvh rounded-xl"
      >
        <p class="text-center font-semibold py-6">
          {{ $t("document.missing_pdf") }}
        </p>
      </object>
    </DialogContent>
  </Dialog>
</template>
