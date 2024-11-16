<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { toast } from 'vue3-toastify';

const { loading, error, sendRequest } = useAxios();

const categories= ref(null);

const extractPage = (url) => {
  if (!url) return 1;

  const match = url.match(/page=(\d+)/);
  return match ? parseInt(match[1]) : 1;
};
const getCategories = async(page) => {
    const res = await sendRequest({
        method: 'get',
        url: `/v1/category?page=${page}`,
    });
    console.log(res);
    categories.value = res?.data
}


const deleteCategory = async(category)  => {
    const response = await sendRequest({
        method:'delete',
        url: `/v1/category/${category}`,
    });
    if(response){
       await getCategories();
        toast.success('Category Deleted Successfully', {autoClose:1000})
    }
}

onMounted(() => {
    getCategories();
})
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <section class="bg-primary rounded-lg shadow-lg">
            <div class=" p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="tabler:category" class="text-xl" />
                        <h3 class="text-base font-medium">Category</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-category" class=" bg-common border border-common px-5 py-2 flex items-center gap-2">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>

            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right">
              <thead class="text-sm uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Icon
                </th>
                <th scope="col" class="px-6 py-3">
                  Banner
                </th>
                <th scope="col" class="px-6 py-3">
                  Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Order Number
                </th>
                <th scope="col" class="px-6 py-3">
                  Parent Category
                </th>

                <th scope="col" class="px-6 py-3">
                  Action
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="category in categories?.data" class="hover:bg-secondary">

                <th class="flex items-center px-6 py-4">
                  <img class="w-10 h-auto" :src="category?.icon" :alt="category?.name">
                </th>

                <td class="px-6 py-4">
                  <img :src="category?.banner" class="w-16 md:w-32 h-auto lg:h-12 max-w-full max-h-full" :alt="category?.name">
                </td>
                <th class=" px-6 py-4 whitespace-nowrap">
                  <div>
                    <div class="font-medium">{{ category?.name }}</div>
                  </div>
                </th>
                <td class="px-6 py-4 text-center">
                  {{ category?.order_number }}
                </td>
                <td class="px-6 py-4 text-center">
                  <span v-if="category?.parent_id === 0" class="bg-green-500 rounded-full    px-3 py-1 text-xs">Main</span>
                  <span v-else class="bg-yellow-500 rounded-full    px-3 py-1 text-xs">{{ category?.parent?.name }}</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
<!--                    <RouterLink :to="`/category/${category?.id}`"  class="w-8 h-8 rounded-md flex items-center justify-center bg-green-500 border border-green-900">-->
<!--                      <Icon  name="material-symbols:visibility-outline-rounded" class="text-xl   " />-->
<!--                    </RouterLink>-->
                    <RouterLink :to="`/edit-category/${category?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                      <Icon name="material-symbols:edit-square-outline" class="text-lg   " />
                    </RouterLink>
                    <button @click="deleteCategory(category?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                      <Icon name="material-symbols:delete-outline" class="text-lg   " />
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
                      v-for="link in categories?.meta?.links"
                      :class="{ 'pagination__right__list__item--active' : link?.active }"
                  >
                    <button
                        @click="getCategories(extractPage(link.url))"
                        class="pagination__right__list__item__link"
                        v-html="link.label">
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
    </AppLayout>
</template>
