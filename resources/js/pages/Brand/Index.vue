<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { toast } from 'vue3-toastify';
const { loading, error, sendRequest } = useAxios();

const brands= ref(null);

const getBrands = async() => {
    const res = await sendRequest({
        method: 'get',
        url: '/v1/brand',
    });
    brands.value = res?.data?.data
}

const deleteBrand = async(brand) => {
    const response = await sendRequest({
        method: 'delete',
        url: `/v1/brand/${brand}`,
    });

    if(response){
        await getBrands();
        toast.success('Brand Deleted Successfully', {autoClose:1000,});
    }
}

onMounted(() => {
    getBrands();
})
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <section class="bg-primary border border-slate-500 text-gray-300">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <Icon name="tabler:brand-abstract"  />
                        <h3 class=" text-base font-medium">Brand</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-brand" class="flex items-center gap-2 border border-common  text-common px-4 py-2">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <Search />
                </div>
            </div>
          <div class="relative overflow-x-auto" >
            <table class="w-full text-sm text-left rtl:text-right">
              <thead class="text-xs  uppercase bg-secondary">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Logo
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
                  Action
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="brand in brands" class="hover:bg-secondary">

                <th class="flex items-center px-6 py-4">
                  <img class="h-16 w-16" :src="brand?.logo">
                </th>

                <td class="px-6 py-4">
                  <img :src="brand?.banner" class="w-16 md:w-32 h-16 max-w-full max-h-full" alt="">
                </td>
                <th scope="row" class="px-6 py-4 ">
                  <div>
                    <div class="text-base font-semibold">{{ brand?.name }}</div>
                  </div>
                </th>
                <td class="px-6 py-4">
                  {{ brand?.order_number }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
                    <RouterLink :to="`/edit-brand/${brand?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                      <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />
                    </RouterLink>
                    <button @click="deleteBrand(brand?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                      <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </section>
    </AppLayout>
</template>
