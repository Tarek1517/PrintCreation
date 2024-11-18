<script setup>
import { RouterView } from 'vue-router'
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed } from 'vue';
import { useRoute } from 'vue-router';
const route = useRoute();
const routeKey = computed(() => route.path + '-' + JSON.stringify(route.query));
</script>

<template>
  <AppLayout>
    <RouterView  :key="routeKey"  />
  </AppLayout>
</template>
