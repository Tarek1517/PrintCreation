<template>
  <section>
    <container>
      <div
        class="relative bg-cover bg-center h-44 w-full lg:mt-10 mt-5 mb-10 rounded-lg overflow-hidden"
        style="background-image: url('/public/slider-2.png')"
      >
        <div
          class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center text-center"
        >
          <h1 class="text-center text-xl lg:text-2xl font-semibold py-10">
            <span class="border-b-4 border-primary">All Products</span>
          </h1>
        </div>
      </div>
    </container>
  </section>
  <section class="pb-10">
    <container>
      <div class="flex">
        <div class="w-1/6 hidden lg:block pt-9">
          <div>
            <h3 class="text-xl lg:text-2xl mb-5 text-primary font-semibold">
              <span class="border-b-2 border-primary font-serif"
                >Categories</span
              >
            </h3>
            <ul class="flex flex-col gap-4">
              <li v-for="category in data?.all_categories">
                <RouterLink
                  class="text-base font-serif block hover:text-primary font-medium hover:font-medium"
                  :to="{
                    path: '/products',
                    query: { category: category?.slug },
                  }"
                  >{{ category?.name }}</RouterLink
                >
              </li>
            </ul>
          </div>
        </div>
        <div class="w-full lg:w-5/6 lg:pl-10 lg:pt-10 lg:pb-10">
          <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-8">
            <ProductCard :data="product" v-for="product in products?.data" />
          </div>
          <div
            class="pagination flex justify-end"
            v-if="products?.data?.length > 0"
          >
            <div>
              <ul class="flex items-center gap-2">
                <li
                  class="w-8 h-8 rounded-full border border-gray-700 cursor-pointer flex items-center justify-center"
                  v-for="link in products?.meta?.links"
                  :class="{ 'bg-primary text-white': link?.active }"
                >
                  <button
                    @click="getProducts(extractPage(link.url))"
                    class="w-full h-full"
                    v-html="link.label"
                  ></button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </container>
  </section>
</template>
<script setup>
import { ref, onMounted, watch, inject } from "vue";
import { useRoute } from "vue-router";
import useAxios from "@/composables/useAxios.js";
import ProductCard from "@/components/ProductCard.vue";
const data = inject("data");

const { loading, error, sendRequest } = useAxios();
const route = useRoute();

const form = ref({
  category_id: null,
  brand_id: null,
  price: null,
});
const extractPage = (url) => {
  window.scrollTo(0, 0);
  if (!url) return 1;
  const match = url.match(/page=(\d+)/);
  return match ? parseInt(match[1]) : 1;
};

const products = ref(null);
const getProducts = async (page) => {
  const response = await sendRequest({
    method: "get",
    url: `/frontend/v1/product?page=${page}`,
    data: form.value,
    params: {
      category: route.query.category,
      search: route.query.search,
    },
  });
  if (response) {
    products.value = response?.data;
  }
};
watch(form, getProducts, { deep: true });

onMounted(() => {
  getProducts();
});
</script>
