<script setup lang="ts">
import { Trash } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Borrow } from "@/types/borrow.js";
import { destroy } from "@/actions/App/Http/Controllers/BorrowController.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import DialogClose from "../ui/dialog/DialogClose.vue";

defineProps<{ borrow: Borrow }>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="destructive" size="icon-sm" class="cursor-pointer">
        <Trash />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center mb-4">
        {{ $t("borrow.confirm_title") }}
      </DialogTitle>

      <Form
        v-bind="destroy.form(borrow)"
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
          {{ $t("global.delete_btn") }}
        </Button>
      </Form>
    </DialogContent>
  </Dialog>
</template>
