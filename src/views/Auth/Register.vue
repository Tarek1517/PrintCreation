<template>
  <AppLayout>
    <div class=" w-full flex justify-center items-center  py-10 lg:py-20">
      <div class="w-[90%] max-w-4xl bg-white flex flex-wrap rounded-xl shadow-xl p-4">
        <div class="w-full lg:w-1/2 lg:pr-5">
          <h3 class="text-2xl font-semibold mb-3">Register</h3>
          <div class="">
            <label for="email" class="block pb-1 text-xs" >Name</label>
            <input type="email" name="email" id="email" v-model="form.name" class="bg-transparent block w-full rounded-md  p-2 shadow-sm border  border-primary focus:outline-none  placeholder:text-gray-400 px-3 mb-2">
          </div>
          <div class="">
            <label for="email" class="block pb-1 text-xs" >Phone</label>
            <input 
                  pattern="[0-9]*" 
                  inputmode="numeric"
                  name="number"
                  id="number"
                v-model="form.phone" class="bg-transparent block w-full rounded-md  p-2 shadow-sm border  border-primary focus:outline-none  placeholder:text-gray-400 px-3 mb-2">
          </div>
          <div class="">
            <label for="email" class="block pb-1 text-xs" >Email</label>
            <input type="email" name="email" id="email" v-model="form.email" class="bg-transparent block w-full rounded-md  p-2 shadow-sm border  border-primary focus:outline-none  placeholder:text-gray-400 px-3 mb-2">
          </div>
          <div class="">
            <label for="password" class="block pb-1 text-xs">Password</label>
            <input type="password" name="password" v-model="form.password"  id="password" class="bg-transparent block w-full rounded-md  p-2  shadow-sm border border-primary focus:outline-none  placeholder:text-gray-400 px-3 mb-2">
          </div>

          <div class="text-center py-5">
            <button @click="handleRegister" class="w-full py-2 bg-primary text-white font-bold text-center rounded-lg my-2">Create Account</button>
          </div>
        </div>
        <div class="hidden lg:block w-1/2">
          <img class="w-full h-96 object-cover rounded-xl" src="https://img.freepik.com/free-photo/hands-working-network-graphic-overlay-banner-desk_53876-101278.jpg">
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/useAuthStore.js';
import { useRouter, useRoute } from 'vue-router'
import { toast } from "vue3-toastify";

const authStore = useAuthStore();
const router = useRouter()
const route = useRoute()

const form = ref({
  name:null,
  phone:null,
  email: null,
  password: null,
});

const handleRegister = async () => {
  const signupResponse = await authStore.register(form.value);
  console.log(signupResponse);
  if (signupResponse) {
    toast.success('Register successful!', { autoClose: 500 });
    router.push('/dashboard');
  }
}
</script>