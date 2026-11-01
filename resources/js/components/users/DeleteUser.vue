<script setup lang="ts">
import { Form } from "@inertiajs/vue3";
import { User } from "@/types/auth.js";
import Button from "../ui/button/Button.vue";
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "../ui/dialog/index.js";
import { Trash } from "@lucide/vue";
import { destroy } from "@/routes/users/index.js";

const props = defineProps<{
  user: User;
}>();
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button size="icon-sm" variant="destructive" class="cursor-pointer">
        <Trash />
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-center mb-4">
          {{ $t("settings.delete_user_title") }}
        </DialogTitle>
      </DialogHeader>

      <Form
        v-bind="destroy.form(props.user)"
        reset-on-success
        :options="{
          preserveScroll: true,
        }"
        v-slot="{ processing }"
        class="flex justify-center gap-4"
      >
        <DialogClose as-child>
          <Button variant="secondary" size="sm">
            {{ $t("settings.cancel_btn") }}
          </Button>
        </DialogClose>

        <DialogClose as-child>
          <Button
            type="submit"
            size="sm"
            variant="destructive"
            :disabled="processing"
          >
            {{ $t("settings.confirm_btn") }}
          </Button>
        </DialogClose>
      </Form>
    </DialogContent>
  </Dialog>
</template>
