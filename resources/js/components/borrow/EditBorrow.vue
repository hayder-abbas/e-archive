<script setup lang="ts">
import { Edit, Save } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { update } from "@/actions/App/Http/Controllers/BorrowController.js";
import { Borrow } from "@/types";
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

const props = defineProps<{ borrow: Borrow }>();
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button
        variant="secondary"
        size="icon-sm"
        class="cursor-pointer"
        data-test="add-box-button"
      >
        <Edit />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center">
        {{ $t("borrow.edit_title") }}
      </DialogTitle>

      <Form
        v-bind="update.form(borrow)"
        v-slot="{ errors, processing, wasSuccessful }"
        class="space-y-4"
      >
        <div class="space-y-2">
          <Label for="lender">{{ $t("borrow.lender") }}</Label>
          <Input
            id="lender"
            type="text"
            name="lender"
            :default-value="borrow.lender"
            v-focus
            :placeholder="$t('borrow.lender_placeholder')"
          />
          <InputError :message="errors.lender" />
        </div>

        <div class="space-y-2">
          <Label for="borrower">{{ $t("borrow.borrower") }}</Label>
          <Input
            id="borrower"
            type="text"
            name="borrower"
            :default-value="borrow.borrower"
            :placeholder="$t('borrow.borrower_placeholder')"
          />
          <InputError :message="errors.borrower" />
        </div>

        <div class="space-y-2">
          <Label for="document">{{ $t("borrow.document") }}</Label>
          <Input
            id="document"
            type="text"
            name="doc_number"
            :default-value="borrow.docNumber"
            :placeholder="$t('borrow.document_placeholder')"
          />
          <InputError :message="errors.doc_number" />
        </div>

        <div class="space-y-2">
          <Label for="borrowDate">{{ $t("borrow.date") }}</Label>
          <Input
            id="borrowDate"
            type="date"
            name="date"
            :default-value="borrow.date"
          />
          <InputError :message="errors.date" />
        </div>

        <!-- Success Message -->
        <InputSuccess
          v-show="wasSuccessful"
          :message="$t('borrow.update_success_message')"
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
