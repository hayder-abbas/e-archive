<script setup lang="ts">
import { CheckIcon, Edit, Save } from "@lucide/vue";
import { Form, usePage } from "@inertiajs/vue3";
import { Boxes, Document, Entities } from "@/types";
import { update } from "@/actions/App/Http/Controllers/DocumentController.js";
import Button from "../ui/button/Button.vue";
import Label from "../ui/label/Label.vue";
import Input from "../ui/input/Input.vue";
import InputError from "../InputError.vue";
import InputSuccess from "../InputSuccess.vue";
import Spinner from "../ui/spinner/Spinner.vue";
import Textarea from "../ui/textarea/Textarea.vue";
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogTitle,
  DialogTrigger,
} from "../ui/dialog/index.js";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "../ui/select/index.js";
import {
  Combobox,
  ComboboxAnchor,
  ComboboxEmpty,
  ComboboxGroup,
  ComboboxInput,
  ComboboxItem,
  ComboboxItemIndicator,
  ComboboxList,
  ComboboxTrigger,
} from "../ui/combobox/index.js";

const props = defineProps<{
  document: Document;
  boxes: Boxes;
  entities: Entities;
}>();

const pageDir = usePage().props.locale === "ar" ? "rtl" : "ltr";

function getBoxNumber(id: number | undefined) {
  return props.boxes.data.find((b) => b.id === id)?.boxNumber ?? "";
}

function getEntityName(id: number | undefined) {
  return props.entities.data.find((e) => e.id === id)?.name ?? "";
}
</script>

<template>
  <Dialog>
    <DialogTrigger>
      <Button size="sm" variant="outline" class="w-full cursor-pointer">
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

        <div class="grid md:grid-cols-2 gap-4">
          <!-- Number -->
          <div class="space-y-2">
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
          <div class="space-y-2">
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

        <div class="grid md:grid-cols-2 gap-4">
          <!-- Box -->
          <div class="space-y-2">
            <Label>{{ $t("document.box_label") }}</Label>
            <Combobox
              :default-value="props.document.box?.id"
              name="box_id"
              :dir="pageDir"
              class="border rounded-lg overflow-hidden"
            >
              <ComboboxAnchor as-child>
                <ComboboxInput
                  :display-value="getBoxNumber"
                  :placeholder="$t('document.box_placeholder')"
                />
                <ComboboxTrigger as-child />
              </ComboboxAnchor>
              <ComboboxList class="max-h-80">
                <ComboboxEmpty>{{ $t("document.no_box_found") }}</ComboboxEmpty>
                <ComboboxGroup>
                  <ComboboxItem
                    v-for="b in props.boxes.data"
                    :key="b.id"
                    :value="b.id"
                  >
                    {{ b.boxNumber }}
                    <ComboboxItemIndicator>
                      <CheckIcon />
                    </ComboboxItemIndicator>
                  </ComboboxItem>
                </ComboboxGroup>
              </ComboboxList>
            </Combobox>
            <InputError :message="errors.box_id" />
          </div>

          <!-- Entity -->
          <div class="space-y-2">
            <Label>{{ $t("document.entity_label") }}</Label>
            <Combobox
              :default-value="props.document.entity?.id"
              name="entity_id"
              :dir="pageDir"
              class="border rounded-lg overflow-hidden"
            >
              <ComboboxAnchor as-child>
                <ComboboxInput
                  :display-value="getEntityName"
                  :placeholder="$t('document.entity_placeholder')"
                />
                <ComboboxTrigger as-child />
              </ComboboxAnchor>
              <ComboboxList class="max-h-80">
                <ComboboxEmpty>
                  {{ $t("document.no_entity_found") }}
                </ComboboxEmpty>
                <ComboboxGroup>
                  <ComboboxItem
                    v-for="e in props.entities.data"
                    :key="e.id"
                    :value="e.id"
                  >
                    {{ e.name }}
                    <ComboboxItemIndicator>
                      <CheckIcon />
                    </ComboboxItemIndicator>
                  </ComboboxItem>
                </ComboboxGroup>
              </ComboboxList>
            </Combobox>
            <InputError :message="errors.entity_id" />
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <!-- Type -->
          <div class="space-y-2">
            <Label>{{ $t("document.type_label") }}</Label>
            <Select name="type" :default-value="document.type">
              <SelectTrigger class="w-full">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="Incoming">
                  {{ $t("document.Incoming") }}
                </SelectItem>
                <SelectItem value="Outgoing">
                  {{ $t("document.Outgoing") }}
                </SelectItem>
              </SelectContent>
            </Select>
            <InputError :message="errors.type" />
          </div>

          <!-- Security -->
          <div class="space-y-2">
            <Label>{{ $t("document.security_label") }}</Label>
            <Select name="security" :default-value="document.security">
              <SelectTrigger class="w-full">
                <SelectValue />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="Normal">
                  {{ $t("document.Normal") }}
                </SelectItem>
                <SelectItem value="Secure">
                  {{ $t("document.Secure") }}
                </SelectItem>
              </SelectContent>
            </Select>
            <InputError :message="errors.security" />
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
          <!-- Belongs To -->
          <div class="space-y-2">
            <Label for="belongsTo">{{ $t("document.belongs_to_label") }}</Label>
            <Input
              id="belongsTo"
              type="text"
              name="belongs_to"
              :default-value="document.belongsTo"
              :placeholder="$t('document.belongs_to_placeholder')"
            />
            <InputError :message="errors.belongs_to" />
          </div>

          <!-- File -->
          <div class="space-y-2">
            <Label for="docFile">{{ $t("document.file_label") }}</Label>
            <Input id="docFile" type="file" name="file" />
            <InputError :message="errors.file" />
          </div>
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
