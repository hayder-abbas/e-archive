<script setup lang="ts">
import { Form } from "@inertiajs/vue3";
import { computed, reactive } from "vue";
import { User } from "@/types/auth.js";
import Button from "../ui/button/Button.vue";
import {
  setAsAdmin,
  setAsUser,
} from "@/actions/App/Http/Controllers/UserController.js";
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "../ui/dialog/index.js";

const props = defineProps<{
  user: User;
}>();

const isAdmin = computed<boolean>(() => props.user.role === "admin");

const role = reactive({
  sudo: "sudo",
  admin: "admin",
  user: "user",
});

const submit = () =>
  !isAdmin.value ? setAsAdmin.form(props.user) : setAsUser.form(props.user);
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button size="sm" variant="secondary" class="cursor-pointer">
        {{ $t(`settings.${role[props.user.role]}`) }}
      </Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle class="text-center mb-4 leading-8">
          {{
            isAdmin
              ? $t("settings.confirm_set_user")
              : $t("settings.confirm_set_admin")
          }}
        </DialogTitle>
      </DialogHeader>

      <Form
        v-bind="submit()"
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
          <Button type="submit" size="sm" :disabled="processing">
            {{ $t("settings.confirm_btn") }}
          </Button>
        </DialogClose>
      </Form>
    </DialogContent>
  </Dialog>
</template>
