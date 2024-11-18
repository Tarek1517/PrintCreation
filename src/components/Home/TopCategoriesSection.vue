<script setup>
import {inject} from 'vue';

const data = inject('data');
</script>
<template>
  <section class="py-5 lg:py-20">
    <container>
      <div>
        <h2 class="text-center text-xl lg:text-6xl font-medium mb-5 lg:mb-10">Top Categories</h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <RouterLink to="/" class="w-full h-40 lg:h-60 relative" v-for="category in data?.top_categories">
            <img class="w-full h-full" :src="category?.icon">
            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-30 p-2 lg:p-4">
              <p class="text-white">{{category?.name}}</p>
              <p class="text-white">{{ category?.products_count }} products</p>
            </div>
          </RouterLink>
        </div>
      </div>
    </container>
  </section>
</template>