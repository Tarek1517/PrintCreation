<script setup lang="ts">
import { ref, onMounted } from 'vue';
import SideBar from '@/components/Layouts/SideBar.vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const isSideBar = ref(false);
onMounted(() => {
    setTimeout(() => {
      isSideBar.value = true;
    }, 3000);
});
</script>

<template>
    <div>
        <div class="w-full flex">
            <aside
                v-if="route.name !== 'Home' && route.name !== 'Login' && isSideBar"
                class="w-56 mx-auto overflow-y-scroll fixed top-0 bottom-0 h-screen bg-primary border-r border-gray-300  transition-all ease-in-out duration-400"
            >
                <SideBar />
            </aside>
            <main
                class=" w-full p-4 ml-56  bg-secondary transition-all ease-in-out duration-400"
            >
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
