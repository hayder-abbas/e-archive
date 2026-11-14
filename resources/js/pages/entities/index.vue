<script setup lang="ts">
import AddEntity from "@/components/entity/AddEntity.vue";
import DeleteEntity from "@/components/entity/DeleteEntity.vue";
import EditEntity from "@/components/entity/EditEntity.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchInput from "@/components/global/SearchInput.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import entities from "@/routes/entities";
import { Can, Entities, Filters } from "@/types";
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

const props = defineProps<{
  entities: Entities;
  filters: Filters;
  can: Can;
}>();
</script>

<template>
  <Head :title="$t('sidebar.entities')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex flex-col-reverse sm:flex-row md:justify-between gap-4">
      <!-- Search -->
      <SearchInput
        :action="entities.index()"
        name="name"
        :value="props.filters.name"
        :placeholder="$t('global.search_by_name')"
        class="md:max-w-lg"
      />

      <!-- Add Entity -->
      <div class="flex sm:justify-end">
        <AddEntity v-if="props.can.create" />
      </div>
    </div>

    <div
      class="relative min-h-screen p-4 flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
    >
      <!-- Entities Table -->
      <Table class="w-full">
        <TableHeader>
          <TableRow class="text-start">
            <TableHead class="text-start">#</TableHead>
            <TableHead class="text-start">
              {{ $t("entity.name") }}
            </TableHead>
            <TableHead class="text-center">
              {{ $t("entity.actions") }}
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="entity in props.entities.data" :key="entity.id">
            <TableCell>{{ entity.id }}</TableCell>
            <TableCell>{{ entity.name }}</TableCell>
            <TableCell class="flex justify-center items-center gap-2">
              <!-- Edit Borrow -->
              <EditEntity v-if="props.can.update" :entity="entity" />
              <!-- Delete Borrow -->
              <DeleteEntity v-if="props.can.delete" :entity="entity" />
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <!-- Paginate -->
      <Paginate :meta="props.entities.meta" />
    </div>
  </div>
</template>
