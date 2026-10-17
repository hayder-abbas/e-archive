<script setup lang="ts">
import { Trash } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Document } from "@/types";
import { destroy } from "@/actions/App/Http/Controllers/DocumentController.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import DialogClose from "../ui/dialog/DialogClose.vue";
import DialogHeader from "../ui/dialog/DialogHeader.vue";

const props = defineProps<{ document: Document }>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="destructive" size="sm" class="cursor-pointer">
        <Trash />
        {{ $t("global.delete_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-center mb-4">
          {{ $t("document.confirm_title") }}
        </DialogTitle>
      </DialogHeader>

      <Form
        v-bind="destroy.form(document)"
        v-slot="{ processing }"
        class="flex justify-center gap-4"
      >
        <DialogClose as-child>
          <Button variant="secondary" size="sm">
            {{ $t("global.cancle_btn") }}
          </Button>
        </DialogClose>

        <Button
          type="submit"
          variant="destructive"
          size="sm"
          :disabled="processing"
        >
          {{ $t("global.delete_btn") }}
        </Button>
      </Form>
    </DialogContent>
  </Dialog>
</template>
