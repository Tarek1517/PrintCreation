<script setup>
import {ref, onMounted} from 'vue';
import useAxios from '@/composables/useAxios';
import { toast } from 'vue3-toastify';
import { useRouter } from 'vue-router';
import {useRoute} from 'vue-router';


const router = useRouter();
const route = useRoute();
const {loadin, error, sendRequest} = useAxios();


const getSlider = async() => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/slider/${route.params.id}`,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
    form.value.id = response.data.id;
    form.value.url = response.data.url;
    form.value.order_number = response.data.order_number;
    sliderImg.value = response.data.image;
}

const sliderImg = ref(null);
const image = (image) => {
    const file = image.target.files[0];
    form.value.image = file;
    sliderImg.value = URL.createObjectURL(file);
}

const form = ref({
    id:null,
    url:null,
    image:null,
    order_number:null
})


const onUpdate = async(id) => {
    const response = await sendRequest({
        url:`/v1/slider/${id}`,
        method: 'post',
        data:form.value,
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        params:{
            _method:'PUT'
        }
    })

    if(response){
        toast.success('Slider Updated Successfully');
        router.push('/slider')
    }
}


onMounted(() => {
    getSlider();
})
</script>
<template>
    <Loading :value="loading" />

        <div class="p-4 shadow max-w-3xl mx-auto">
            <h3 class="text-base mb-5">Add New Home Slider {{ form.status }}</h3>
            <div class="flex flex-col gap-5">
                <div class="w-full">
                    <label for="url" class="text-sm block mb-1">URL</label>
                    <input type="text" class="p-2 rounded-md border w-full" v-model="form.url">
                </div>
                <div class="w-full flex gap-5">
                    <div>
                        <label for="url" class="text-sm block mb-1">Order Number</label>
                        <input type="number" class="p-2 rounded-md border w-full" v-model="form.order_number">
                    </div>
                </div>

                <div class="w-full">
                    <label for="slider-image" class="text-sm block mb-2">Slider Image</label>
                    <label for="slider-image" class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-72 cursor-pointer">
                        <img v-if="sliderImg" :src="sliderImg" class="w-full h-full rounded-md">
                        <div v-if="!sliderImg" class="flex flex-col items-center justify-center gap-2">
                            <Icon name="tabler:cloud-upload" class="text-common text-5xl opacity-85" />
                            <span class="text-common font-semibold opacity-85">Upload Slider Image</span>
                        </div>
                        <input id="slider-image" @change="image" type="file" hidden>
                    </label>
                </div>
                <div>
                    <button @click="onUpdate(form.id)" class="bg-common text-center            w-full py-2 rounded">Update Slider</button>
                </div>
            </div>
        </div>

</template>