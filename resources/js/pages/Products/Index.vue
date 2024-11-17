<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { toast } from "vue3-toastify";

const { loading, error, sendRequest } = useAxios();

    const categories = ref(null);
    const brands = ref(null);


    const getCategories = async() => {
        const response = await sendRequest({
            method:'get',
            url:'/v1/get-all-category-list',
        }); 
        categories.value = response?.data
    }

    // brands
    const getBrands = async() => {
        const response = await sendRequest({
            method:'get',
            url:'/v1/get-all-brand-list',
        }); 
        brands.value = response?.data
    }

const products = ref(null);

const extractPage = (url) => {
  if (!url) return 1;

  const match = url.match(/page=(\d+)/);
  return match ? parseInt(match[1]) : 1;
};
const getProducts = async(page) => {
    const res  = await sendRequest({
        method: 'get',
        url: `/v1/product?page=${page}`,
    });
    products.value = res?.data
}



const deleteProduct = async(product) => {
    const response = await sendRequest({
        method:'delete',
        url: `/v1/product/${product}`,
    });
    if(response){
      await getProducts();
      toast.success('Product Deleted Successfully', {autoClose:1000})
    }
}

onMounted(() => {
    getCategories(); 
    getBrands(); 
    getProducts();
})
</script>
<template>
    <Loading :value="loading" />

        <section class="bg-primary shadow-lg rounded-md">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <Icon name="carbon:ibm-data-product-exchange" class="text-lg " />
                        <h3 class="text-base font-medium">Products</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-product" class="border border-common bg-common  px-4 py-2 flex items-center gap-2">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
                <div class="flex items-center justify-between bg-base-color">
                    <Search />
                </div>
            </div>
            <div class="relative overflow-hidden bg-primary shadow-md ">
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left">
                <thead class="text-sm  uppercase bg-common">
                <tr>
                  <th scope="col" class="p-4">
                    <div class="flex items-center">
                      <input id="checkbox-all" type="checkbox" class="w-4 h-4 bg-secondary border-slate-500 rounded focus:ring-primary-500 ">
                      <label for="checkbox-all" class="sr-only">checkbox</label>
                    </div>
                  </th>
                  <th scope="col" class="px-4 py-3">Product</th>
                  <th scope="col" class="px-4 py-3">Category</th>
                  <th scope="col" class="px-4 py-3">Stock</th>
                  <th scope="col" class="px-4 py-3">Price</th>
				  <th scope="col" class="px-4 py-3">Attachment</th>
				  <th scope="col" class="px-4 py-3">Attachment Type</th>
				  <th scope="col" class="px-4 py-3">Status</th>
                  <th scope="col" class="px-4 py-3">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products?.data" class=" hover:bg-secondary">
                  <td class="w-4 px-4 py-3">
                    <div class="flex items-center">
                      <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 bg-secondary border-slate-6600 rounded focus:ring-primary-500">
                      <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                  </td>
                  <th scope="row" class="flex items-center px-4 py-2 font-medium max-w-xs">
                    <img :src="product?.cover_image" class="w-auto h-8 mr-3">
                    {{ product?.title }}
                  </th>
                  <td class="px-4 py-2">
                    <span class="bg-primary-100  text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300">{{ product?.category?.name }}</span>
                  </td>
                 
                  <td class="px-4 py-2 font-medium">
                    {{ product?.stock }}
                  </td>
                  <td class="px-4 py-2 font-medium ">
                    <p v-if="product?.discount_price"> <strike class="mr-1 text-red-500">৳{{ product?.price }}</strike>৳{{ product?.discount_price }}</p>
                    <p v-else>৳{{ product?.price }}</p>
                  </td>
                  <td class="px-4 py-2 font-medium uppercase">{{product?.attachment ? 'Yes' : 'No'}}</td>
                  <td class="px-4 py-2 font-medium uppercase">{{product?.attachment_type ? product?.attachment_type : 'No'}}</td>
                  <td class="px-4 py-2 font-medium uppercase">{{product?.status ?'Active' : 'Inactive'}}</td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
  <!--                      <RouterLink :to="`/product-detail/${product?.slug}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-green-500 border border-green-900">-->
  <!--                        <Icon  name="material-symbols:visibility-outline-rounded" class="text-xl text-white" />-->
  <!--                      </RouterLink>-->
                      <RouterLink :to="`/edit-product-variation/${product?.slug}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-sky-500 border border-sky-900">
                        <Icon name="material-symbols-light:rule-settings-rounded" class="text-lg text-white" />
                      </RouterLink>
                      <RouterLink :to="`/edit-product/${product?.slug}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                        <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />
                      </RouterLink>
                      <button @click = "deleteProduct(product?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                        <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                      </button>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
<!--              pagination -->
              <div class="p-5">
                <div class="pagination flex justify-end">
                  
                  <div class="pagination__right">
                    <ul class="pagination__right__list">
                      <li
                          class="pagination__right__list__item"
                          v-for="link in products?.meta?.links"
                          :class="{ 'pagination__right__list__item--active' : link?.active }"
                      >
                        <button
                            @click="getProducts(extractPage(link.url))"
                            class="pagination__right__list__item__link"
                            v-html="link.label">
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
          </div>
        </section>
</template>
