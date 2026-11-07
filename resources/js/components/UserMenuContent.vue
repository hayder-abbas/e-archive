<script setup lang="ts">
import { computed } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { LogOut, Settings } from "@lucide/vue";
import {
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import UserInfo from "@/components/UserInfo.vue";
import { logout } from "@/routes";
import { edit } from "@/routes/profile";
import type { User } from "@/types";

type Props = {
  user: User;
};

const handleLogout = () => {
  router.flushAll();
};

defineProps<Props>();

const rtl = computed(() => usePage().props.locale === "ar");
</script>

<template>
  <!-- User Info -->
  <DropdownMenuLabel class="p-0 font-normal">
    <div
      class="flex justify-start items-center gap-2 px-1 py-1.5 text-left text-sm"
      :class="{ 'flex-row-reverse': rtl }"
    >
      <UserInfo :user="user" :show-email="true" :rtl="rtl" />
    </div>
  </DropdownMenuLabel>

  <DropdownMenuSeparator />

  <!-- Settings -->
  <DropdownMenuGroup>
    <DropdownMenuItem :as-child="true">
      <Link
        class="flex justify-start items-center w-full cursor-pointer"
        :class="{ 'flex-row-reverse': rtl }"
        :href="edit()"
        prefetch
      >
        <Settings class="mr-2 h-4 w-4" />
        {{ $t("sidebar.settings") }}
      </Link>
    </DropdownMenuItem>
  </DropdownMenuGroup>

  <DropdownMenuSeparator />

  <!-- Logout -->
  <DropdownMenuItem :as-child="true">
    <Link
      class="flex justify-start items-center w-full cursor-pointer"
      :class="{ 'flex-row-reverse': rtl }"
      :href="logout()"
      @click="handleLogout"
      as="button"
      data-test="logout-button"
    >
      <LogOut class="mr-2 h-4 w-4" />
      {{ $t("sidebar.logout") }}
    </Link>
  </DropdownMenuItem>
</template>
