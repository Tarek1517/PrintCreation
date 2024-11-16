<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { toast } from 'vue3-toastify';
const { loading, error, sendRequest } = useAxios();

const sliders= ref(null);

const getSliders = async() => {
    const response = await sendRequest({
        method: 'get',
        url: '/v1/slider',
    });
    sliders.value = response.data
}




const onDelete = async(id) => {
    const response = await sendRequest({
        method:'delete',
        url:`/v1/slider/${id}`,
    })


    if(response)
    {
        toast.success('Slider Deleted Successfully', {autoClose:1000});
        getSliders();
    }
}
onMounted(() => {
    getSliders();
})
</script>
<template>
    <Loading :value="loading" />
        <section class="shadow-lg rounded-lg text-sm ">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="solar:slider-minimalistic-horizontal-bold" class="text-lg" />
                        <h3 class="text-base font-medium">Slider</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-slider" class="flex items-center gap-2  px-4 py-2 border border-common bg-common">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <Search />
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-left rtl:text-right ">
              <thead class="uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Banner
                </th>
                <th scope="col" class="px-6 py-3">
                  URL
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
              <tr v-for="slider in sliders?.data" class="hover:bg-secondary">
                <td class="px-6 py-4">
                  <img :src="slider?.image" class="w-16 md:w-32 h-auto" alt="">
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <a :href="slider?.url">{{ slider?.url }}</a>
                  </div>
                </td>
                <td class="px-6 py-4">
                  {{ slider?.order_number }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
                    <RouterLink :to="`/edit-slider/${slider?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-green-500 border border-green-900">
                      <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />
                    </RouterLink>
                    <button @click="onDelete(slider?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                      <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </section>
</template>
