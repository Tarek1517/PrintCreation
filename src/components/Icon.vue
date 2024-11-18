<script setup>
import { Icon } from "@iconify/vue";

const props = defineProps({
  name: {
    type: String,
  }
});
</script>
<template>
  <Icon :icon="name"  />
</template>