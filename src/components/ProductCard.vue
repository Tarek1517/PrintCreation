<script setup>
import { inject } from "vue";
const props = defineProps({
  data: Object,
});

const setting = inject("data");
</script>
<template>
  <div
    class="max-w-sm border border-gray-200 rounded-lg  hover:custom-brown shadow-custom-brown transform hover:scale-105 transition-transform duration-300 hover:bg-primary group"
  >
    <!-- Product Image -->
    <RouterLink :to="`/product/${data?.slug}`" class="w-full h-45 lg:h-45 block">
      <div class="p-3">
        <img
          class="w-full h-40 lg:h-60 object-cover rounded-t-lg"
          :src="data?.cover_image_url"
          :alt="data?.title"
        />
      </div>
    </RouterLink>

    <!-- Product Details -->
    <div class="lg:p-6 pl-3 pb-5 pr-3">
      <!-- Product Title -->
      <RouterLink
        :to="`/product/${data?.slug}`"
        class="lg:text-lg text-base font-medium text-gray-800 transition-colors duration-300 font-serif block lg:mb-2 mb-0 group-hover:text-white"
      >
        {{ data?.title }}
      </RouterLink>

      <!-- Price Section -->
      <p class="text-sm lg:text-base text-gray-500 flex items-center gap-2">
        <strike class="text-red-700 text-xs group-hover:text-slate-400">
          <span class="text-xs">$</span>{{ setting?.currency_symbol
          }}{{ data?.price }}
        </strike>
        <span
          class="text-primary font-semibold group-hover:text-white font-serif"
        >
          <span class="text-xl">$</span>{{ setting?.currency_symbol
          }}{{ data?.discount_price }}
        </span>
      </p>
    </div>
  </div>
</template>
