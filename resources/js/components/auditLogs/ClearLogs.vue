<script setup lang="ts">
import { Trash } from "@lucide/vue";
import { Form } from "@inertiajs/vue3";
import { AuditLog } from "@/types";
import { destroy } from "@/actions/App/Http/Controllers/AuditLogController.js";
import Button from "../ui/button/Button.vue";
import Dialog from "../ui/dialog/Dialog.vue";
import DialogTrigger from "../ui/dialog/DialogTrigger.vue";
import DialogContent from "../ui/dialog/DialogContent.vue";
import DialogTitle from "../ui/dialog/DialogTitle.vue";
import DialogClose from "../ui/dialog/DialogClose.vue";

const props = defineProps<{ auditLog: AuditLog }>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="destructive" size="sm" class="cursor-pointer">
        <Trash />
        {{ $t("audit_logs.clear_btn") }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogTitle class="text-center mb-6">
        {{ $t("audit_logs.confirm_title") }}
      </DialogTitle>

      <Form
        v-bind="destroy.form(props.auditLog)"
        :options="{
          preserveScroll: true,
        }"
        v-slot="{ processing }"
        class="flex justify-center gap-4"
      >
        <DialogClose as-child>
          <Button variant="secondary">
            {{ $t("global.cancle_btn") }}
          </Button>
        </DialogClose>

        <DialogClose as-child>
          <Button type="submit" variant="destructive" :disabled="processing">
            {{ $t("global.delete_btn") }}
          </Button>
        </DialogClose>
      </Form>
    </DialogContent>
  </Dialog>
</template>
