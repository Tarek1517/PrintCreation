<script setup lang="ts">
    import moment from 'moment';
    import {ref, onMounted} from 'vue';
    import useAxios from '@/composables/useAxios.js';
import { toast } from 'vue3-toastify';
    const request = ref(null);
    const {loading, error, sendRequest} = useAxios();

    const getAllRequest = async () => {
        const response = await sendRequest({
            method: 'get',
            url:'/v1/get-all-request',
        });
        if(response){
            request.value = response.data;
        }
    }

    const deleteRequest = async(id) => {
        const response = await sendRequest({
            method:'get',
            url:`/v1/delete-request/${id}`
        });
        if(response)
        {
            toast.success('Request Deleted Succesfully', {autoClose:500});
            getAllRequest();
        }
    }

onMounted(() => {
    getAllRequest();
});
</script>
<template>
    <Loading :value="loading" />
    <div>
        <h3 class="text-white font-normal mb-4">Order Request</h3>
        <div class="flex flex-wrap">
            <div class="w-1/2 px-3" v-for="item  in request">
                <div class="p-3 bg-primary border border-slate-600 relative">
                    <button @click="deleteRequest(item?.id)" class="absolute top-2 right-2 w-8 h-8 flex items-center justify-center rounded bg-common text-white">
                        <Icon name="tabler:trash" />
                    </button>
                    <p class="mb-4 text-white">Requested: {{ moment(item?.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</p>
                    <ul class="flex flex-col gap-3">
                        <li class="text-white text-sm font-normal flex">
                            <span class="w-1/4">Product:</span>
                            <span class="w-3/4">{{ item?.product }}</span>
                        </li>
                        <li class="text-white text-sm font-normal flex">
                            <span class="w-1/4">Name:</span>
                            <span class="w-3/4">{{ item?.name }}</span>
                        </li>
                        <li class="text-white text-sm font-normal flex">
                            <span  class="w-1/4">Phone:</span>
                            <span class="w-3/4">{{item?.phone}}</span>
                        </li>
                        <li class="text-white text-sm font-normal flex">
                            <span  class="w-1/4">Email:</span>
                            <span  class="w-3/4">{{ item?.email }}</span>
                             
                        </li>
                        <li class="text-white text-sm font-normal flex">
                            <span  class="w-1/4">Address:</span>
                            <span  class="w-3/4">{{ item?.address }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>