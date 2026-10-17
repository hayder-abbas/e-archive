<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import {
  FileBox,
  Files,
  HandCoins,
  Landmark,
  LayoutGrid,
  Logs,
  Trash,
} from "@lucide/vue";
import AppLogo from "@/components/AppLogo.vue";
import NavFooter from "@/components/NavFooter.vue";
import NavMain from "@/components/NavMain.vue";
import NavUser from "@/components/NavUser.vue";
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar";
import { dashboard, trash } from "@/routes";
import type { NavItem } from "@/types";
import boxes from "@/routes/boxes";
import entities from "@/routes/entities";
import borrows from "@/routes/borrows";
import auditLogs from "@/routes/audit-logs";
import { computed } from "vue";
import documents from "@/routes/documents";

const locale = computed(() => usePage().props.locale);

const mainNavItems: NavItem[] = [
  {
    title: "sidebar.dashboard",
    href: dashboard(),
    icon: LayoutGrid,
  },
  {
    title: "sidebar.documents",
    href: documents.index(),
    icon: Files,
  },
  {
    title: "sidebar.boxes",
    href: boxes.index(),
    icon: FileBox,
  },
  {
    title: "sidebar.borrows",
    href: borrows.index(),
    icon: HandCoins,
  },
  {
    title: "sidebar.entities",
    href: entities.index(),
    icon: Landmark,
  },
];

const footerNavItems: NavItem[] = [
  {
    title: "sidebar.audit_logs",
    href: auditLogs.index(),
    icon: Logs,
  },
  {
    title: "sidebar.trash",
    href: trash(),
    icon: Trash,
  },
];
</script>

<template>
  <Sidebar
    collapsible="icon"
    variant="inset"
    :side="locale === 'en' ? 'left' : 'right'"
  >
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="dashboard()">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>
