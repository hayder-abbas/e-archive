<script setup lang="ts">
import { Trash } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Box } from "@/types";
import { destroy } from "@/actions/App/Http/Controllers/BoxController.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import DialogClose from "../ui/dialog/DialogClose.vue";
import DialogHeader from "../ui/dialog/DialogHeader.vue";
import DialogDescription from "../ui/dialog/DialogDescription.vue";

const props = defineProps<{ box: { data: Box } }>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button
        variant="destructive"
        size="sm"
        data-test="delete-entity-button"
        class="cursor-pointer"
      >
        <Trash />
        {{ $t("box.delete_box_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-center mb-4">
          {{ $t("box.confirm_title") }}
        </DialogTitle>
        <DialogDescription class="text-center mb-6">
          {{ $t("box.confirm_description") }}
        </DialogDescription>
      </DialogHeader>

      <Form
        v-bind="destroy.form(box.data)"
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
          data-test="confirm-delete-entity-button"
        >
          {{ $t("global.delete_btn") }}
        </Button>
      </Form>
    </DialogContent>
  </Dialog>
</template>
