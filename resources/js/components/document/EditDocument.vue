<script setup lang="ts">
import { Edit, Save } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { Boxes, Document, Entities } from "@/types";
import { update } from "@/actions/App/Http/Controllers/DocumentController.js";
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
import Select from "../ui/select/Select.vue";
import SelectTrigger from "../ui/select/SelectTrigger.vue";
import SelectValue from "../ui/select/SelectValue.vue";
import SelectContent from "../ui/select/SelectContent.vue";
import SelectItem from "../ui/select/SelectItem.vue";
import DialogClose from "../ui/dialog/DialogClose.vue";
import Textarea from "../ui/textarea/Textarea.vue";

const props = defineProps<{
  document: Document;
  boxs: Boxes;
  entities: Entities;
}>();
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button size="sm" variant="outline" class="cursor-pointer">
        <Edit />
        {{ $t("global.edit_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent class="min-h-fit max-h-160 overflow-auto">
      <DialogTitle class="text-center">
        {{ $t("document.edit_title") }}
      </DialogTitle>

      <Form
        v-bind="update.form(document)"
        reset-on-success
        v-slot="{ errors, processing, wasSuccessful }"
        class="space-y-4"
      >
        <!-- Subject -->
        <div class="space-y-2">
          <Label for="subject">{{ $t("document.subject_label") }}</Label>
          <Input
            id="subject"
            type="text"
            name="subject"
            :default-value="document.subject"
            :placeholder="$t('document.subject_placeholder')"
          />
          <InputError :message="errors.subject" />
        </div>

        <div class="flex items-center gap-4">
          <!-- Number -->
          <div class="space-y-2 flex-1">
            <Label for="docNumber">{{ $t("document.number_label") }}</Label>
            <Input
              id="docNumber"
              type="text"
              name="number"
              :default-value="document.number"
              :placeholder="$t('document.number_placeholder')"
            />
            <InputError :message="errors.number" />
          </div>

          <!-- Date -->
          <div class="space-y-2 flex-1">
            <Label for="docDate">{{ $t("document.date_label") }}</Label>
            <Input
              id="docDate"
              type="date"
              name="date"
              :default-value="document.date"
            />
            <InputError :message="errors.date" />
          </div>
        </div>

        <div class="flex gap-4 items-center">
          <!-- Box -->
          <div class="space-y-2 flex-1">
            <Label>{{ $t("document.box_label") }}</Label>
            <Select name="box_id" :default-value="document.box?.id">
              <SelectTrigger class="w-full">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem
                  v-for="b in props.boxs.data"
                  :key="b.id"
                  :value="b.id"
                >
                  {{ b.boxNumber }}
                </SelectItem>
              </SelectContent>
            </Select>
            <InputError :message="errors.box_id" />
          </div>

          <!-- Entity -->
          <div class="space-y-2 flex-1">
            <Label>{{ $t("document.entity_label") }}</Label>
            <Select name="entity_id" :default-value="document.entity?.id">
              <SelectTrigger class="w-full">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem
                  v-for="en in props.entities.data"
                  :key="en.id"
                  :value="en.id"
                >
                  {{ en.name }}
                </SelectItem>
              </SelectContent>
            </Select>
            <InputError :message="errors.entity_id" />
          </div>
        </div>

        <div class="flex gap-4 items-center">
          <!-- Type -->
          <div class="space-y-2 flex-1">
            <Label>{{ $t("document.type_label") }}</Label>
            <Select name="type" :default-value="props.document.type">
              <SelectTrigger class="w-full">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="Incoming">
                  {{ $t("document.incoming") }}
                </SelectItem>
                <SelectItem value="Outgoing">
                  {{ $t("document.outgoing") }}
                </SelectItem>
              </SelectContent>
            </Select>
            <InputError :message="errors.type" />
          </div>

          <!-- Security -->
          <div class="space-y-2 flex-1">
            <Label>{{ $t("document.security_label") }}</Label>
            <Select name="security" :default-value="document.security">
              <SelectTrigger class="w-full">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="Normal">
                  {{ $t("document.normal") }}
                </SelectItem>
                <SelectItem value="Secure">
                  {{ $t("document.secure") }}
                </SelectItem>
              </SelectContent>
            </Select>
            <InputError :message="errors.security" />
          </div>
        </div>

        <!-- File -->
        <div class="space-y-2">
          <Label for="docFile">{{ $t("document.file_label") }}</Label>
          <Input id="docFile" type="file" name="file" />
          <InputError :message="errors.file" />
        </div>

        <!-- Notes -->
        <div class="space-y-2">
          <Label for="notes">{{ $t("document.notes_label") }}</Label>
          <Textarea
            id="notes"
            type="text"
            name="notes"
            :default-value="document.notes"
            :placeholder="$t('document.notes_placeholder')"
          />
          <InputError :message="errors.notes" />
        </div>

        <!-- Success Message -->
        <InputSuccess
          v-show="wasSuccessful"
          :message="$t('document.update_success_message')"
        />

        <div class="flex justify-end gap-4">
          <DialogClose as-child>
            <Button variant="secondary">
              {{ $t("global.close_btn") }}
            </Button>
          </DialogClose>

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
