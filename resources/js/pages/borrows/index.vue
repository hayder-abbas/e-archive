<script setup lang="ts">
import AddBorrow from "@/components/borrow/AddBorrow.vue";
import DeleteBorrow from "@/components/borrow/DeleteBorrow.vue";
import EditBorrow from "@/components/borrow/EditBorrow.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchInput from "@/components/global/SearchInput.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import borrows from "@/routes/borrows";
import { Borrows, Can, Filters } from "@/types";
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

const props = defineProps<{
  borrows: Borrows;
  filters: Filters;
  can: Can;
}>();
</script>

<template>
  <Head :title="$t('sidebar.borrows')" />

  <div class="flex h-full flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <!-- Searchs -->
    <div class="flex flex-col-reverse md:flex-row gap-4">
      <div class="flex flex-col md:flex-row gap-4 w-full md:w-5/6 2xl:w-4/6">
        <SearchInput
          :action="borrows.index()"
          name="lender"
          :value="props.filters.lender"
          :placeholder="$t('global.search_by_lender')"
        />

        <SearchInput
          :action="borrows.index()"
          name="borrower"
          :value="props.filters.borrower"
          :placeholder="$t('global.search_by_borrower')"
        />

        <SearchInput
          :action="borrows.index()"
          name="number"
          :value="props.filters.number"
          :placeholder="$t('global.search_by_number')"
        />
      </div>

      <!-- Add new borrow button -->
      <div class="flex sm:justify-end w-full md:w-1/6 2xl:w-2/6">
        <AddBorrow v-if="props.can.create" />
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
              <EditBorrow v-if="props.can.update" :borrow="b" />
              <!-- Delete Borrow -->
              <DeleteBorrow v-if="props.can.delete" :borrow="b" />
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <!-- Paginate -->
      <Paginate :meta="props.borrows.meta" />
    </div>
  </div>
</template>
