<script setup>
import useAxios from '@/composables/useAxios';
import { ref, watch,inject } from 'vue';
import {onClickOutside} from '@vueuse/core';

const {loading, error, sendRequest} = useAxios();
const search = ref(null);
const target = ref(null)
const products = ref(null);
const isPreview = ref(false);
const data = inject('data');

const getProducts = async () => {
  const response = await sendRequest({
    method:'get',
    url:'/frontend/v1/product',
    params: {
      search: search.value,
    }
  });
  if(response){
    products.value = response.data;
    isPreview.value = true;
  }
}
onClickOutside(target, () => { isPreview.value = false })

watch(search, getProducts, { deep: true });
</script>
<template>
  <div class="flex items-center  relative  border border-primary">
    <input v-model="search" type="text"  class="py-2.5 pl-3 border border-secondary rounded focus:outline-0 lg:w-full " placeholder="Search Sign & Print Creation...." />
    <RouterLink
        :to="{
            path:'/products',
            query: {search: search}
        }"
        class="-ml-[49px] h-full  bg-primary text-white flex items-center gap-2 py-3 px-5">
      <Icon name="radix-icons:magnifying-glass" class="text-2xl" />
      Search
    </RouterLink>


    <div v-if="isPreview && search" ref="target" class=" absolute top-14 left-0 right-0 w-full h-[600px] overflow-y-scroll bg-white z-30 shadow-lg rounded-md pt-10">
      <div class="flex items-center justify-between p-2 absolute top-0 right-0 left-0 bg-white">
        <p>Searching for: "{{ search }}"</p>
        <p>{{ products?.data?.length }} results found</p>
      </div>
      <div v-if="products?.data?.length === 0" class="w-full h-full p-5 flex flex-col items-center gap-4">
     
        <p class="text-center text-lg">Oops! It looks like we don’t have what you're looking for. Please search again with different keywords.</p>
        <RouterLink to="/products" class="text-blue-600 flex items-center gap-1">
          All Products
          <Icon name="material-symbols:arrow-right-alt-rounded" class="text-xl" />
        </RouterLink>
      </div>
      <div v-else class="flex flex-col gap-2" v-for="product in products?.data">
        <RouterLink :to="`/product/${product?.slug}`" class="flex gap-3 p-3 hover:bg-slate-100">
          <img class="w-16 min-h-16 h-auto" :src="product?.cover_image_url" alt="">
          <div>
				<h3>{{ product?.title }}</h3>
				<p>{{data?.currency_symbol}} {{product?.price}}</p>
		  </div>
        </RouterLink>
      </div>
    </div>
  </div>
</template>