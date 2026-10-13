<script setup lang="ts">
import ClearLogs from "@/components/auditLogs/ClearLogs.vue";
import Input from "@/components/ui/input/Input.vue";
import Table from "@/components/ui/table/Table.vue";
import TableBody from "@/components/ui/table/TableBody.vue";
import TableCell from "@/components/ui/table/TableCell.vue";
import TableHead from "@/components/ui/table/TableHead.vue";
import TableHeader from "@/components/ui/table/TableHeader.vue";
import TableRow from "@/components/ui/table/TableRow.vue";
import auditLogs from "@/routes/audit-logs";
import { AuditLogs } from "@/types/auditlog";
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

const props = defineProps<{ auditLogs: { data: AuditLogs[] } }>();
</script>

<template>
  <Head :title="$t('sidebar.audit_logs')" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="flex justify-end items-center gap-4">
      <!-- Search -->
      <Input :placeholder="$t('global.search_by_name')" />
      <Input :placeholder="$t('global.search_by_number')" />

      <!-- Clear Logs -->
      <ClearLogs />
    </div>

    <div
      class="relative min-h-screen p-4 flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
    >
      <!-- Audit Logs Table -->
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead class="text-start">#</TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.name") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.action") }}
            </TableHead>
            <TableHead class="text-start">
              {{ $t("audit_logs.date") }}
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="audit in props.auditLogs.data" :key="audit.id">
            <TableCell>{{ audit.id }}</TableCell>
            <TableCell>{{ audit.name }}</TableCell>
            <TableCell>{{ audit.action }}</TableCell>
            <TableCell>
              {{ new Date(audit.createdAt).toLocaleString() }}
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>
