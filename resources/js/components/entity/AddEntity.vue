<script setup lang="ts">
import { Plus } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { store } from "@/routes/entities/index.js";
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
</script>

<template>
  <Dialog>
    <DialogTrigger class="w-full md:w-fit">
      <Button class="cursor-pointer w-full" data-test="add-entity-button">
        <Plus />
        {{ $t("entity.new_entity") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center">
        {{ $t("entity.add_title") }}
      </DialogTitle>

      <Form
        v-bind="store.form()"
        reset-on-success
        v-slot="{ errors, processing, wasSuccessful }"
        class="space-y-4"
      >
        <Label for="entityName">{{ $t("entity.name") }}</Label>
        <Input
          id="entityName"
          type="text"
          name="name"
          v-focus
          :placeholder="$t('entity.placeholder')"
        />
        <!-- Error Message -->
        <InputError :message="errors.name" />
        <!-- Success Message -->
        <InputSuccess
          v-if="wasSuccessful"
          :message="$t('entity.add_success_message')"
        />

        <div class="flex justify-end">
          <Button type="submit" :disabled="processing">
            <Spinner v-if="processing" />
            {{ $t("global.add_btn") }}
          </Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
