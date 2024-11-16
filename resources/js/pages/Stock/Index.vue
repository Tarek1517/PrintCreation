<script setup>
import useAxios from "@/composables/useAxios"
import { toast } from "vue3-toastify";
import { ref, onMounted } from "vue";
import { useRouter} from 'vue-router';
const { loading, error, sendRequest } = useAxios();
const router = useRouter();

const stocks = ref(null);
const extractPage = (url) => {
  if (!url) return 1;

  const match = url.match(/page=(\d+)/);
  return match ? parseInt(match[1]) : 1;
};
const getStocks = async(page) => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/product-stock?page=${page}`,
    });
    if(response){
        stocks.value = response.data;
    }
}

const onDelete = async(id) => {
    const response = await sendRequest({
        method:'delete',
        url:`/v1/product-stock/${id}`,
    });
    if(response){
        toast.success('Stock Deleted Successfully', {autoClose:500});
    }
}


onMounted(() => {
    getStocks();
})
</script>
<template>
        <Loading :value="loading" />
        <section class="text-sm font-norma shadow-lg rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="simple-icons:nginxproxymanager" class="text-lg" />
                        <h3 class="text-base">Product Stock</h3>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <Search />
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-left rtl:text-right">
              <thead class="uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Product
                </th>
                <th scope="col" class="px-6 py-3">
                  Variant
                </th>
                <th scope="col" class="px-6 py-3">
                  Stock Status
                </th>
                <th scope="col" class="px-6 py-3">
                  Current Stock
                </th>
                <th scope="col" class="px-6 py-3">
                  Price
                </th>
                <th scope="col" class="px-6 py-3">
                  Action
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="stock in stocks?.data" class="hover:bg-secondary">
                <td class="flex items-center px-4 py-2 ">
                  <img :src="stock?.product?.cover_image" class="w-auto h-8 mr-3">
                  {{ stock?.product?.title }}
                </td>
                <td class="px-6 py-4">
                  {{ stock?.varient }}
                </td>
                <td class="px-6 py-4">
                  In Stock
                </td>
                <td class="px-6 py-4">
                  {{ stock?.stock }}
                </td>
                <td class="px-6 py-4">
                  ${{ stock?.price }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
                    <button @click="onDelete(stock?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                      <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="p-5">
            <div class="pagination flex justify-end">

              <div class="pagination__right">
                <ul class="pagination__right__list">
                  <li
                      class="pagination__right__list__item"
                      v-for="link in stocks?.meta?.links"
                      :class="{ 'pagination__right__list__item--active' : link?.active }"
                  >
                    <button
                        @click="getStocks(extractPage(link.url))"
                        class="pagination__right__list__item__link"
                        v-html="link.label">
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
</template>