<script setup lang="ts">
import ClearLogs from "@/components/auditLogs/ClearLogs.vue";
import Paginate from "@/components/global/Paginate.vue";
import Button from "@/components/ui/button/Button.vue";
import Input from "@/components/ui/input/Input.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import auditLogs from "@/routes/audit-logs";
import { AuditLogs } from "@/types";
import { Form, Head } from "@inertiajs/vue3";

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
  filters: {
    name: string | null;
    number: string | null;
  };
}>();
</script>

<template>
  <Head :title="$t('sidebar.audit_logs')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div
      class="flex flex-wrap justify-between gap-4 flex-col md:flex-row lg:items-center"
    >
      <!-- Search -->
      <div class="flex gap-4 w-full md:w-fit">
        <!-- Search by Name -->
        <Form
          method="get"
          :action="auditLogs.index()"
          class="w-full flex flex-col md:flex-row gap-4"
        >
          <Input
            name="name"
            :default-value="props.filters.name || ''"
            :placeholder="$t('global.search_by_name')"
          />
          <Input
            name="number"
            :default-value="props.filters.number || ''"
            :placeholder="$t('global.search_by_number')"
          />

          <Button type="submit" variant="secondary">
            {{ $t("global.search_btn") }}
          </Button>
        </Form>
      </div>

      <!-- Clear Logs -->
      <div class="flex justify-end items-center w-full md:w-fit">
        <ClearLogs :auditLog="props.auditLogs.data[0]" />
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
