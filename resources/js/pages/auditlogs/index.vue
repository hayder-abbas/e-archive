<script setup lang="ts">
import ClearLogs from "@/components/auditLogs/ClearLogs.vue";
import Paginate from "@/components/global/Paginate.vue";
import SearchInput from "@/components/global/SearchInput.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import auditLogs from "@/routes/audit-logs";
import { AuditLogs, Can, Filters } from "@/types";
import { Head } from "@inertiajs/vue3";

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: "sidebar.audit_logs",
        href: auditLogs.index(),
      },
    ],
  },
});

const props = defineProps<{
  auditLogs: AuditLogs;
  filters: Filters;
  can: Can;
}>();
</script>

<template>
  <Head :title="$t('sidebar.audit_logs')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex flex-col-reverse md:flex-row lg:justify-between gap-4">
      <!-- Searchs -->
      <div class="flex flex-col sm:flex-row gap-4 w-full max-w-3xl">
        <SearchInput
          :action="auditLogs.index()"
          name="name"
          :value="props.filters.name"
          :placeholder="$t('global.search_by_name')"
        />

        <SearchInput
          :action="auditLogs.index()"
          name="number"
          :value="props.filters.number"
          :placeholder="$t('global.search_by_number')"
        />
      </div>

      <!-- Clear Logs -->
      <div class="flex sm:justify-end">
        <ClearLogs
          v-if="props.can.delete"
          :auditLog="props.auditLogs.data[0]"
        />
      </div>
    </div>

    <div
      class="relative min-h-screen p-4 flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
    >
      <!-- Audit Logs Table -->
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead class="text-start">
              {{ $t("audit_logs.user_id") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.username") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.action") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.target_type") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.target_number") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.date") }}
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="audit in props.auditLogs.data" :key="audit.id">
            <TableCell>{{ audit.userId }}</TableCell>
            <TableCell>{{ audit.username }}</TableCell>
            <TableCell>{{ $t(`audit_logs.${audit.action}`) }}</TableCell>
            <TableCell>{{ $t(`audit_logs.${audit.targetType}`) }}</TableCell>
            <TableCell>{{ audit.targetNumber }}</TableCell>
            <TableCell>
              {{ new Date(audit.createdAt).toLocaleString() }}
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <!-- Pagination -->
      <Paginate :meta="props.auditLogs.meta" />
    </div>
  </div>
</template>
