<script setup lang="ts">
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { useInitials } from "@/composables/useInitials";
import type { User } from "@/types";

type Props = {
  user: User;
  showEmail?: boolean;
  rtl?: boolean;
};

const props = withDefaults(defineProps<Props>(), {
  showEmail: false,
  rtl: false,
});

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
const showAvatar = computed(
  () => props.user.avatar && props.user.avatar !== "",
);
</script>

<template>
  <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
    <AvatarImage v-if="showAvatar" :src="user.avatar!" :alt="user.name" />
    <AvatarFallback class="rounded-lg text-black dark:text-white">
      {{ getInitials(user.name) }}
    </AvatarFallback>
  </Avatar>

  <div class="grid flex-1 text-sm leading-tight">
    <span
      class="flex items-center gap-2 truncate font-medium"
      :class="{ 'flex-row-reverse': rtl }"
    >
      {{ user.name }}
      <small class="text-slate-500 font-semibold">
        ({{ $t("sidebar." + user.role) }})
      </small>
    </span>
    <span
      v-if="showEmail"
      class="flex truncate text-xs text-muted-foreground"
      :class="{ 'flex-row-reverse': rtl }"
    >
      {{ user.email }}
    </span>
  </div>
</template>
