<script setup lang="ts">
import AddBorrow from "@/components/borrow/AddBorrow.vue";
import DeleteBorrow from "@/components/borrow/DeleteBorrow.vue";
import EditBorrow from "@/components/borrow/EditBorrow.vue";
import FilterByType from "@/components/global/FilterByType.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchByDate from "@/components/global/SearchByDate.vue";
import Input from "@/components/ui/input/Input.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import borrows from "@/routes/borrows";
import { Borrows } from "@/types";
import { Head } from "@inertiajs/vue3";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.borrows",
        href: borrows.index(),
      },
    ],
  },
});

const props = defineProps<{ borrows: Borrows }>();
</script>

<template>
  <Head :title="$t('sidebar.borrows')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Add new borrow button -->
    <div class="flex justify-end items-center">
      <AddBorrow />
    </div>

    <div
      class="flex flex-wrap justify-between gap-4 flex-col lg:flex-row lg:items-center"
    >
      <!-- Search by date -->
      <SearchByDate />

      <div class="flex gap-4">
        <!-- Search by doc-no -->
        <Input :placeholder="$t('global.search_by_number')" />

        <!-- Filter by type -->
        <FilterByType class="md:flex-1 lg:flex-none" />
      </div>
    </div>

    <!-- Documents -->
    <div
      class="relative min-h-screen p-4 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border overflow-hidden"
    >
      <Table class="w-full">
        <TableHeader>
          <TableRow class="text-start">
            <TableHead class="text-start">#</TableHead>
            <TableHead class="text-start">{{ $t("borrow.lender") }}</TableHead>
            <TableHead class="text-start">
              {{ $t("borrow.borrower") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("borrow.document") }}
            </TableHead>
            <TableHead class="text-start">{{ $t("borrow.date") }}</TableHead>
            <TableHead class="text-start">{{ $t("borrow.actions") }}</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="b in props.borrows.data" :key="b.id">
            <TableCell>{{ b.id }}</TableCell>
            <TableCell>{{ b.lender }}</TableCell>
            <TableCell>{{ b.borrower }}</TableCell>
            <TableCell>{{ b.docNumber }}</TableCell>
            <TableCell>{{ b.date }}</TableCell>
            <TableCell class="space-x-2">
              <!-- Edit Borrow -->
              <EditBorrow :borrow="b" />
              <!-- Delete Borrow -->
              <DeleteBorrow :borrow="b" />
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <!-- Paginate -->
      <Paginate :meta="props.borrows.meta" />
    </div>
  </div>
</template>
