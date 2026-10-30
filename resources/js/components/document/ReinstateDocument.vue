<script setup lang="ts">
import { FileCheckCorner } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Document } from "@/types";
import { reinstate } from "@/actions/App/Http/Controllers/DocumentController.js";
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
      <Button size="sm" variant="secondary" class="cursor-pointer">
        <FileCheckCorner />
        {{ $t("document.reinstate_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-center mb-4">
          {{ $t("document.reinstate_confirm") }}
        </DialogTitle>
      </DialogHeader>

      <Form
        v-bind="reinstate.form(props.document)"
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

        <Button type="submit" size="sm" :disabled="processing">
          {{ $t("document.reinstate_btn") }}
        </Button>
      </Form>
    </DialogContent>
  </Dialog>
</template>
