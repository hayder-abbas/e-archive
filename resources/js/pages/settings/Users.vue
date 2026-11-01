<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import { User } from "@/types";
import Heading from "@/components/Heading.vue";
import AddUserRole from "@/components/users/AddUserRole.vue";
import DeleteUser from "@/components/users/DeleteUser.vue";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { computed } from "vue";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "settings.users_title",
        href: "#",
      },
    ],
  },
});

const props = defineProps<{
  users: { data: User[] };
}>();

const filteredUsers = computed(() =>
  props.users.data.filter((u) => u.role !== "sudo"),
);
</script>

<template>
  <Head :title="$t('settings.users_title')" />

  <h1 class="sr-only">{{ $t("settings.users_title") }}</h1>

  <div class="flex flex-col space-y-6">
    <Heading
      variant="small"
      :title="$t('settings.users_title')"
      :description="$t('settings.users_description')"
    />

    <Table>
      <TableHeader>
        <TableRow>
          <TableHead class="text-start">#</TableHead>
          <TableHead class="text-start">
            {{ $t("settings.name_col") }}
          </TableHead>
          <TableHead class="text-start">
            {{ $t("settings.email_col") }}
          </TableHead>
          <TableHead class="text-center">
            {{ $t("settings.role_col") }}
          </TableHead>
          <TableHead class="text-center">
            {{ $t("settings.delete_col") }}
          </TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        <TableRow v-for="user in filteredUsers" :key="user.id">
          <TableCell>{{ user.id }}</TableCell>
          <TableCell>{{ user.name }}</TableCell>
          <TableCell>{{ user.email }}</TableCell>
          <TableCell class="text-center">
            <AddUserRole :user="user" />
          </TableCell>
          <TableCell class="text-center">
            <DeleteUser :user="user" />
          </TableCell>
        </TableRow>
      </TableBody>
    </Table>
  </div>
</template>
