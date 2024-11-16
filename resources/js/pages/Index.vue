<script setup lang="ts">
import {onMounted, ref} from 'vue';
import { useAdminStore } from '@/stores/useAdminStore.js';
import { useRouter } from 'vue-router'
import {toast} from "vue3-toastify";
const router = useRouter();
const isForm = ref(false);

  const adminStore = useAdminStore();
//Login
const state = ref({
  email: 'tushar@admin.com',
  password: 'tushar',
});

const loading = ref(false);

const handleLogin = async () => {
  try {
    const loginResponse = await adminStore.login(state.value);
    if (loginResponse) {
      loading.value = false;
      toast.success('Login successful!', { autoClose: 1000 });
      setTimeout(() => {
        router.push({ name: "Dashboard" });
      },1000);
    }
  } catch (error) {
    loading.value = false;
    toast.error(error.response?.data?.message || 'Login failed. Please try again.', { autoClose: 1000 });
  }
}
onMounted(() => {
  setTimeout(() => {
    isForm.value = true;
  },500);
})
</script>

<template>
  <Loading :value="loading" />
  <div class="w-full h-screen bg-secondary flex items-center justify-between relative overflow-hidden">
    <div
        class="absolute left-1/2 -translate-x-1/2 w-full mx-auto max-w-xl px-4 bg-primary shadow rounded p-5 border border-slate-600 text-gray-300 transition-all ease-in-out duration-700"
        :class="{'top-1/2 -translate-y-1/2' : isForm, 'top-[1200px]' : !isForm}">

      <h3 class="text-center font-medium text-3xl uppercase mb-3">Sign in To Dashboard{{ user }}</h3>
      <div class="flex flex-col items-center gap-5">
        <div class="w-full">
          <label for="email" class="flex items-center gap-2">Email</label>
          <input type="text" class="rounded-md w-full text-gray-300" v-model="state.email">
        </div>
        <div class="w-full">
          <label for="password" class="flex items-center gap-2">Password</label>
          <input type="text" v-model="state.password" class="w-full text-gray-300 rounded-md">
        </div>
        <div class="w-full">
          <button @click="handleLogin" class="bg-common text-center py-2 w-full text-white rounded-md">Access Dashboard</button>
        </div>
      </div>
    </div>
  </div>
</template>