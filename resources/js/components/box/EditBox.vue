<script setup lang="ts">
import { Edit, Save } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { update } from "@/actions/App/Http/Controllers/BoxController.js";
import { Box } from "@/types";
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

const props = defineProps<{ box: { data: Box } }>();
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button
        variant="outline"
        class="cursor-pointer"
        data-test="add-box-button"
      >
        <Edit />
        {{ $t("box.edit_box_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center">
        {{ $t("box.edit_title") }}
      </DialogTitle>

      <Form
        v-bind="update.form(box.data)"
        v-slot="{ errors, processing, wasSuccessful }"
        class="space-y-4"
      >
        <div class="space-y-2">
          <Label for="boxName">{{ $t("box.name") }}</Label>
          <Input
            id="boxName"
            type="text"
            name="box_name"
            :default-value="box.data.boxName"
            v-focus
            :placeholder="$t('box.name_placeholder')"
          />
          <InputError :message="errors.box_name" />
        </div>

        <div class="space-y-2">
          <Label for="boxNumber">{{ $t("box.number") }}</Label>
          <Input
            id="boxNumber"
            type="text"
            name="box_number"
            :default-value="box.data.boxNumber"
            :placeholder="$t('box.number_placeholder')"
          />
          <InputError :message="errors.box_number" />
        </div>

        <div class="space-y-2">
          <Label for="boxDate">{{ $t("box.date") }}</Label>
          <Input
            id="boxDate"
            type="date"
            name="box_date"
            :default-value="box.data.boxDate"
          />
          <InputError :message="errors.box_date" />
        </div>

        <!-- Success Message -->
        <InputSuccess
          v-show="wasSuccessful"
          :message="$t('box.update_success_message')"
        />

        <div class="flex justify-end">
          <Button type="submit" :disabled="processing">
            <Spinner v-if="processing" />
            <Save v-else />
            {{ $t("global.save_btn") }}
          </Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
