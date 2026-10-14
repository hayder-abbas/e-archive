<script setup lang="ts">
import { Edit } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Entity } from "@/types";
import { update } from "@/routes/entities/index.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import Label from "../ui/label/Label.vue";
import Input from "../ui/input/Input.vue";
import InputError from "../InputError.vue";
import InputSuccess from "../InputSuccess.vue";
import Spinner from "../ui/spinner/Spinner.vue";

const props = defineProps<{ entity: Entity }>();
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button variant="outline" size="icon-sm" class="cursor-pointer">
        <Edit />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center">
        {{ $t("entity.edit_title") }}
      </DialogTitle>

      <Form
        v-bind="update.form(entity)"
        reset-on-success
        v-slot="{ errors, processing, wasSuccessful }"
        class="space-y-4"
      >
        <Label for="entityName">{{ $t("entity.name") }}</Label>
        <Input
          id="entityName"
          type="text"
          name="name"
          :model-value="entity.name"
          v-focus
          :placeholder="$t('entity.placeholder')"
        />
        <!-- Error Message -->
        <InputError :message="errors.name" />
        <!-- Success Message -->
        <InputSuccess
          v-if="wasSuccessful"
          :message="$t('entity.update_success_message')"
        />

        <div class="flex justify-end">
          <Button type="submit" :disabled="processing">
            <Spinner v-if="processing" />
            {{ $t("global.save_btn") }}
          </Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
