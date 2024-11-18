<script setup>
import ProductCard from "@/components/ProductCard.vue";
import { inject } from "vue";

const data = inject('data');
</script>

<template>
  <section class="py-5 lg:py-20">
    <container>
      <div>
        <h2 class="text-center text-xl lg:text-6xl font-medium mb-4 lg:mb-10">Our Products</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <ProductCard :data="product" v-for="product in data?.home_products" />
        </div>
      </div>
    </container>
  </section>
</template>
