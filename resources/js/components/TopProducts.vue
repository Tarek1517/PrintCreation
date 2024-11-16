<script setup>
const props = defineProps({
  data:Object,
});
</script>
<template>
<div class="relative overflow-x-auto bg-primary border border-slate-600">
          <h3 class="p-3 text-base font-medium     ">Top Products</h3>
          <table class="w-full text-sm text-left rtl:text-right text-black">

            <thead class="text-xs uppercase bg-common">
            <tr>
              <th scope="col" class="px-16 py-3">
                <span class="sr-only">Image</span>
              </th>
              <th scope="col" class="px-6 py-3">
                Product
              </th>
              <th scope="col" class="px-6 py-3 ">
                Price
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in data" class="text-gray-300 hover:bg-secondary">
              <td class="py-1 px-6">
                <img  :src="product?.cover_image" class="w-10 max-w-full max-h-full" alt="Apple Watch">
              </td>
              <td class="px-6 py-1 font-semibold text-xs">
                {{ product?.title }}
              </td>
              <td class="px-6 py-1 font-semibold text-xs">
                {{product?.price}}
              </td>
            </tr>
            </tbody>
          </table>
        </div>
</template>