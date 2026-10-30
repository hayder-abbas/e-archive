<script setup lang="ts">
import { FileXCorner } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Document } from "@/types";
import { revoke } from "@/actions/App/Http/Controllers/DocumentController.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import DialogClose from "../ui/dialog/DialogClose.vue";
import DialogHeader from "../ui/dialog/DialogHeader.vue";
import DialogDescription from "../ui/dialog/DialogDescription.vue";

const props = defineProps<{ document: Document }>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button size="sm" variant="destructive" class="cursor-pointer">
        <FileXCorner />
        {{ $t("document.revoke_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-center mb-4">
          {{ $t("document.revoke_confirm") }}
        </DialogTitle>
        <DialogDescription class="text-center mb-6">
          {{ $t("document.revoke_confirm_desc") }}
        </DialogDescription>
      </DialogHeader>

      <Form
        v-bind="revoke.form(props.document)"
        reset-on-success
        :options="{
          preserveScroll: true,
        }"
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
          {{ $t("document.revoke_btn") }}
        </Button>
      </Form>
    </DialogContent>
  </Dialog>
</template>
