
<script setup>
import {ref} from 'vue';
import useAxios from '@/composables/useAxios';
import { toast } from 'vue3-toastify';
import { useRouter } from 'vue-router';

const router = useRouter();
const {loadin, error, sendRequest} = useAxios();


const sliderImg = ref(null);
const image = (image) => {
    const file = image.target.files[0];
    form.value.company_logo = file;
    sliderImg.value = URL.createObjectURL(file);
}

const form = ref({
    company_name:null,
    company_logo:null,
    delivery_charge:null
})

const onSubmit = async() => {
    const response = await sendRequest({
        url:'/v1/courier-company',
        method: 'post',
        data:form.value,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })

    if(response){
        toast.success('Courier Company Created Successfully');
        router.push('/courier-company')

    }
}

</script>
<template>
    <Loading :value="loading" />

        <div class="p-4 shadow-lg rounded-lg max-w-3xl mx-auto">
            <h3 class="text-base mb-5">Add New Home Courier Company</h3>
            <div class="flex flex-col gap-5">
                <div class="w-full">
                    <label for="url" class="text-sm block mb-1">Company Name</label>
                    <input type="text" class="p-2 rounded-md border w-full" v-model="form.company_name">
                </div>
                <div class="w-full flex gap-5">
                    <div>
                        <label for="url" class="text-sm block mb-1">Delivery Charge</label>
                        <input type="number" class="p-2 rounded-md border w-full" v-model="form.delivery_charge">
                    </div>
                </div>

                <div class="w-full">
                    <label for="slider-image" class="text-sm block mb-2">Company Logo</label>
                    <label for="slider-image" class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-72 cursor-pointer">
                        <img v-if="sliderImg" :src="sliderImg" class="w-full h-full rounded-md">
                        <div v-if="!sliderImg" class="flex flex-col items-center justify-center gap-2">
                            <Icon name="tabler:cloud-upload" class="text-common text-5xl opacity-85" />
                            <span class="text-common font-semibold opacity-85">Upload Company Logo</span>
                        </div>
                        <input id="slider-image" @change="image" type="file" hidden>
                    </label>
                </div>
                <div>
                    <button @click="onSubmit" class="bg-common text-center            w-full py-2 rounded">Save Company</button>
                </div>
            </div>
        </div>

</template>