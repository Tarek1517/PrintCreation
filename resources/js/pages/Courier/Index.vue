<script setup>
import { onMounted, ref } from 'vue';
import useAxios from "@/composables/useAxios"
import { toast } from 'vue3-toastify';
const { loading, error, sendRequest } = useAxios();

const companies= ref(null);

const getCompany = async() => {
    const response = await sendRequest({
        method: 'get',
        url: '/v1/courier-company',
    });
    companies.value = response.data
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
    getCompany();
})
</script>
<template>
    <Loading :value="loading" />
        <section class="shadow-lg rounded-lg text-sm ">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="solar:slider-minimalistic-horizontal-bold" class="text-lg" />
                        <h3 class="text-base font-medium">Courier Company</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-courier-company" class="flex items-center gap-2  px-4 py-2 border border-common bg-common">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-left rtl:text-right ">
              <thead class="uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Compnay Logo
                </th>
                <th scope="col" class="px-6 py-3">
                  Company Name
                </th>
                <th scope="col" class="px-6 py-3">
                 Delivery Charge
                </th>
                <th scope="col" class="px-6 py-3">
                  Action
                </th>
              </tr>
              </thead>

              <tbody>
              <tr v-for="company in companies" class="hover:bg-secondary">
                <td class="px-6 py-4">
                  <img :src="company?.company_logo" class="w-16 h-auto" alt="">
                </td>
                <td class="px-6 py-4">
					{{ company?.company_name }}
                </td>
                <td class="px-6 py-4">
                  {{ company?.delivery_charge }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
                    <button @click="onDelete(company?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
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
