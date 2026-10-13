<script setup lang="ts">
import { Plus, Save } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
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
import { store } from "@/actions/App/Http/Controllers/BorrowController.js";
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button class="cursor-pointer" data-test="add-box-button">
        <Plus />
        {{ $t("borrow.add_borrow_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center">
        {{ $t("borrow.add_title") }}
      </DialogTitle>

      <Form
        v-bind="store.form()"
        reset-on-success
        v-slot="{ errors, processing, wasSuccessful }"
        class="space-y-4"
      >
        <div class="space-y-2">
          <Label for="lender">{{ $t("borrow.lender") }}</Label>
          <Input
            id="lender"
            type="text"
            name="lender"
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
            :placeholder="$t('borrow.document_placeholder')"
          />
          <InputError :message="errors.doc_number" />
        </div>

        <div class="space-y-2">
          <Label for="borrowDate">{{ $t("borrow.date") }}</Label>
          <Input id="borrowDate" type="date" name="date" />
          <InputError :message="errors.date" />
        </div>

        <!-- Success Message -->
        <InputSuccess
          v-show="wasSuccessful"
          :message="$t('borrow.add_success_message')"
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
