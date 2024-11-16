<script setup>
import {ref, onMounted} from 'vue';
import useAxios from '@/composables/useAxios';
import {useRouter} from 'vue-router';
import { toast } from 'vue3-toastify';

const {error, loading, sendRequest} = useAxios();
const router = useRouter();

const form = ref({
    name:null,
    area_code:null,
    condition_charge:null,
    condition_price:null,
    delevery_charge:null,
})

const onSubmit = async() => {
    const response = await sendRequest({
        method:'post',
        url:'/v1/shipping-area',
        data:form.value
    })

    if(response){
        toast.success('Shipping Area Added Succesfully', {autoClose:1000})
        router.push('/shipping')
    }
}
</script>
<template>
    <Loading :value="loading" />

        <div class="w-full max-w-2xl bg-white mx-auto shadow-lg p-4">
            <h3>Add new shipping area</h3>
            <div class="flex flex-col gap-3">
                <div class="flex">
                    <div class="w-full lg:w-1/2 pr-2">
                        <label for="name" class="text-sm  mb-1">Area Name</label>
                        <input id="name" type="text" class="p-2 rounded-md border w-full" v-model="form.name">
                    </div>
                    <div class="w-full lg:w-1/2  pl-2">
                        <label for="area-code" class="text-sm   mb-1">Area Code</label>
                        <input id="area-code" type="number" class="p-2 rounded-md border w-full" v-model="form.area_code">
                    </div>
                </div>
                <div class="flex">
                    <div class="w-full lg:w-1/2 pr-2">
                        <label for="delevery-charge" class="text-sm mb-1">Delevery Charge</label>
                        <input id="delevery-charge" type="number" class="p-2 rounded-md border w-full" v-model="form.delevery_charge">
                    </div>
                </div>
                <div class="w-full mt-5">
                    <Button class="w-full rounded" @click='onSubmit'>Save Sipping</Button>
                </div>
            </div>
        </div>

</template>