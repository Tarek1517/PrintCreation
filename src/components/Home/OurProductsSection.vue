<script setup>
import ProductCard from "@/components/ProductCard.vue";
import { inject } from "vue";

const data = inject("data");
</script>

<template>
  <section class="py-5 lg:py-10">
    <container>
      <div>
        <h2 class="text-center text-2xl lg:text-4xl font-medium mb-8 lg:mb-20">
          <span class="border-b-4 border-primary font-serif">Our Products</span>
        </h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 lg:gap-6 gap-4">
          <ProductCard :data="product" v-for="product in data?.home_products" />
        </div>
      </div>
      <div class="flex justify-center lg:mt-11 mt-7">
        <RouterLink to="/products">
          <button class="border-b-2 border-primary text-black text-sm lg:text-xl px-3 font-serif hover:text-primary">
            View All Products
          </button>
        </RouterLink>
      </div>
    </container>
  </section>
</template>
