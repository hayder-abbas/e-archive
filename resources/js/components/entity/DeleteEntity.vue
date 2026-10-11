<script setup lang="ts">
import { Trash } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Entity } from "@/types/entity.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import EntityController from "@/actions/App/Http/Controllers/EntityController.js";
import DialogClose from "../ui/dialog/DialogClose.vue";

const props = defineProps<{ entity: Entity }>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="destructive" size="sm" data-test="delete-entity-button">
        <Trash />
        {{ $t("global.delete_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center mb-6">
        {{ $t("entity.confirm") }}
      </DialogTitle>

      <Form
        v-bind="EntityController.destroy.form(entity)"
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
