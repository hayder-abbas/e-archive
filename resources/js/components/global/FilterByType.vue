<script setup lang="ts">
import Select from "../ui/select/Select.vue";
import SelectContent from "../ui/select/SelectContent.vue";
import SelectItem from "../ui/select/SelectItem.vue";
import SelectTrigger from "../ui/select/SelectTrigger.vue";
import SelectValue from "../ui/select/SelectValue.vue";
</script>

<template>
  <div>
    <Select>
      <SelectTrigger>
        <SelectValue :placeholder="$t('global.all')" />
      </SelectTrigger>

      <SelectContent>
        <SelectItem value="all">{{ $t("global.all") }}</SelectItem>
        <SelectItem value="incoming">{{ $t("document.Incoming") }}</SelectItem>
        <SelectItem value="outgoing">{{ $t("document.Outgoing") }}</SelectItem>
      </SelectContent>
    </Select>
  </div>
</template>
