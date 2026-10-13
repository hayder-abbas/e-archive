<script setup lang="ts">
import AddEntity from "@/components/entity/AddEntity.vue";
import DeleteEntity from "@/components/entity/DeleteEntity.vue";
import EditEntity from "@/components/entity/EditEntity.vue";
import Input from "@/components/ui/input/Input.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import entities from "@/routes/entities";
import { Entity } from "@/types/entity";
import { Head } from "@inertiajs/vue3";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.entities",
        href: entities.index(),
      },
    ],
  },
});

const props = defineProps<{ entities: Entity[] }>();
</script>

<template>
  <Head :title="$t('sidebar.entities')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex justify-end items-center gap-4">
      <!-- Search -->
      <Input :placeholder="$t('global.search_by_name')" />

      <!-- Add Entity Dialog -->
      <AddEntity />
    </div>

    <div
      class="relative min-h-screen p-4 flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
    >
      <!-- Entities Table -->
      <Table class="w-full">
        <TableHeader>
          <TableRow class="text-start">
            <TableHead class="text-start">#</TableHead>
            <TableHead class="text-start">{{ $t("entity.name") }}</TableHead>
            <TableHead class="text-center">
              {{ $t("entity.actions") }}
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="entity in props.entities" :key="entity.id">
            <TableCell>{{ entity.id }}</TableCell>
            <TableCell>{{ entity.name }}</TableCell>
            <TableCell class="flex justify-center items-center gap-2">
              <!-- Edit Borrow -->
              <EditEntity :entity="entity" />
              <!-- Delete Borrow -->
              <DeleteEntity :entity="entity" />
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>
