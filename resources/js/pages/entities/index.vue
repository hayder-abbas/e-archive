<script setup lang="ts">
import AddEntity from "@/components/entity/AddEntity.vue";
import DeleteEntity from "@/components/entity/DeleteEntity.vue";
import EditEntity from "@/components/entity/EditEntity.vue";
import Input from "@/components/ui/input/Input.vue";
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
      <div>
        <table class="w-full">
          <thead class="border-b">
            <tr class="grid grid-cols-12 pb-2">
              <th class="col-span-1">#</th>
              <th class="col-span-7">{{ $t("entity.name") }}</th>
              <th class="col-span-4">{{ $t("entity.actions") }}</th>
            </tr>
          </thead>
          <tbody class="block pb-4">
            <tr
              v-for="(entity, index) in props.entities"
              :key="entity.id"
              class="grid grid-cols-12 py-2 border-b leading-7"
            >
              <td class="col-span-1 text-center">{{ index + 1 }}</td>
              <td class="col-span-7">{{ entity.name }}</td>
              <td class="col-span-4 flex gap-2 justify-center items-center">
                <!-- Edit Entity Dialog -->
                <EditEntity :entity="entity" />

                <!-- Delete Entity Dialog -->
                <DeleteEntity :entity="entity" />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
