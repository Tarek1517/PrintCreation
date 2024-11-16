<script setup>
import AppLayout from "@/components/Layouts/AppLayout.vue";
import useAxios from '@/composables/useAxios';
import {ref, onMounted} from 'vue'; 
import { toast } from "vue3-toastify";

const {loading, error, sendRequest} = useAxios();

const areas = ref(null);
const getAreas = async() => {
    const response = await sendRequest({
        method:'get',
        url:'/v1/shipping-area',
    })

    areas.value = response.data
}


const onDelete = async(id) => {
    const response = await sendRequest({
        method:'delete',
        url:`/v1/shipping-area/${id}`,
    })

    if(response){
        toast.success('Shipping Area Deleted Successfully');
        getAreas();
    }
}

onMounted(() => {
    getAreas();
})
</script>
<template>
    <Loading :value="loading" />
        <section class="p-4">
            <div >
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        <Icon name="streamline:shipping-transfer-cart-package-box-fulfillment-cart-warehouse-shipping-delivery" />
                        <h3 class="text-xl font-semibold">Shipping</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-shipping" class="flex items-center gap-2 bg-common   px-4 py-2 text-base">
                            <Icon name="material-symbols:add-box-outline" />
                            Add New Shipping
                        </RouterLink>
                    </div>
                </div>
            </div>
        </section>
        <div class="mx-5">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm ">
                    <thead class="text-xs uppercase bg-common">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Area Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Area Code
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
                    <tr v-for="area in areas" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">
                            {{ area?.name }}
                        </td>
                        <th class="px-6 py-4">
                            {{ area?.area_code }}
                        </th>
                        <th class="px-6 py-4">
                            {{area?.delevery_charge}}
                        </th>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <RouterLink :to="`/edit-shipping/${area.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-400/10 border border-yellow-900">
                                    <Icon name="material-symbols:edit-square-outline" class="text-lg text-yellow-900" />
                                </RouterLink>
                                <button @click="onDelete(area?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-400/10 border border-red-900">
                                    <Icon name="material-symbols:delete-outline" class="text-lg text-red-900" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
</template>
