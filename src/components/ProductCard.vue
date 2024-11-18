<script setup>
import { inject } from 'vue';
	const props = defineProps({
			data: Object
	});

const setting = inject('data');
</script>
<template>
  <div>
    <RouterLink :to="`/product/${data?.slug}`" class="w-full h-48 lg:h-72 block">
      <img class="w-full h-full" :src="data?.cover_image_url">
    </RouterLink>
    <div class="p-3">
      <RouterLink to="/product" class="text-base font-normal mb-3 block">{{data?.title}}</RouterLink>
      <p class="text-primary text-sm lg:text-xl  flex items-center gap-1">
		<strike class="text-red-400">{{setting?.currency_symbol}}{{data?.price}}</strike>
		{{setting?.currency_symbol}}{{data?.discount_price}}
	</p>
    </div>
  </div>	
</template>