<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useAuthStore } from "./stores/useAuthStore.js";
import { computed, onMounted } from 'vue';
import { useRoute,RouterView } from 'vue-router';
const route = useRoute();
const routeKey = computed(() => route.path + '-' + JSON.stringify(route.query));

onMounted(() => {
	// const authStore = useAuthStore();
	// authStore.fetchUser();
})
</script>

<template>
  <AppLayout>
    <RouterView  :key="routeKey"  />
  </AppLayout>
</template>
