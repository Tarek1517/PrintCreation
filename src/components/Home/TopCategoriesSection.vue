<script setup>
import { inject } from "vue";

const data = inject("data");
</script>
<template>
  <section class="py-5 lg:py-20">
    <container>
      <div>
        <h2 class="text-center text-2xl lg:text-4xl font-medium mb-10 lg:mb-20">
          <span class="border-b-4 border-primary font-serif">Top Categories</span>
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
          <RouterLink
            to="/"
            class="w-full h-40 lg:h-60 relative border border-gray-200 rounded-lg shadow hover:shadow-lg object-cover rounded-t-lg overflow-hidden"
            v-for="category in data?.top_categories"
          >
            <img
              class="w-full h-full transform hover:scale-150 transition-transform duration-500"
              :src="category?.icon_url"
            />
            <div
              class="absolute bottom-0 left-0 right-0 bg-black hover:bg-primary hover:bg-opacity-70 bg-opacity-30 p-2 lg:p-4"
            >
              <p class="text-white text-sm lg:text-base font-serif">{{ category?.name }}</p>
              <p class="text-orange-300 text-xs lg:text-base font-serif">{{ category?.products_count }} products</p>
            </div>
          </RouterLink>
        </div>
      </div>
    </container>
  </section>
</template>
