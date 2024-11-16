<script setup>
import  SummernoteEditor  from 'vue3-summernote-editor';
import useAxios from "@/composables/useAxios"
import { toast } from "vue3-toastify";
import { ref, onMounted } from "vue";
import { useRouter, useRoute} from 'vue-router'
const { loading, error, sendRequest } = useAxios();
const router = useRouter();
const route = useRoute();

const logoImg = ref(null);
const bannerImg = ref(null);


const getBrand = async () => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/brand/${route.params.id}`
    });
    if(response?.data){
        form.value.name = response.data.name;
        form.value.order_number = response.data.order_number;
        form.value.description = response.data.description;
        logoImg.value = response.data.logo;
        bannerImg.value = response.data.banner;
    }
}

const form = ref({
    name: null,
    logo:null,
    banner: null,
    status:1,
    order_number: null,
    description: null,
});

const banner = (banner) => {
    const file = banner.target.files[0];
    form.value.banner = file;
    bannerImg.value = URL.createObjectURL(file);
}
const logo = (logo) => {
    const file = logo.target.files[0];
    form.value.logo = file;
    logoImg.value = URL.createObjectURL(file);
}


const onSubmit = async() => {
    console.log(form.value);
    const response = await sendRequest({
        method: 'post',
        url: `/v1/brand/${route.params.id}`,
        data: form.value,
        params: {
            _method: 'PUT'
            },
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
    if(response?.data){
        toast.success( `${response?.data?.name} Brand Updated Succesfully`, {autoclose:1000});
        await router.push('/brand');
    }
}

onMounted(async() => {
    await getBrand();   
});
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <div class="bg-primary shadow-md p-6 max-w-5xl mx-auto text-gray-300">
            <h3 class="mb-10">Update Brand</h3>
            <div>
                <div class="flex flex-wrap items-center">
                    <div class="w-1/2 pr-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Brand Name</label>
                            <input v-model="form.name" type="text" class="border border-primary rounded-md font-normal text-sm w-full">
                        </div>
                    </div>
                    <div class="w-1/2 pr-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Order Number</label>
                            <input v-model="form.order_number" type="number" class="border border-primary rounded-md font-normal text-sm w-full">
                        </div>
                    </div>
                    
                </div>
                <div class="flex items-center my-10">
                    <div class="w-1/3 pr-2">
                        <div class="w-full">
                            <label for="brand-image" class="text-sm block mb-2">Brand Image</label>
                            <label class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer" for="brand-image">
                                <img v-if="logoImg" :src="logoImg" class="w-full h-full">
                                <div v-if="!logoImg" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-common text-5xl opacity-85" />
                                    <span class="text-common font-semibold opacity-85">Upload Brand Logo</span>
                                </div>
                                <input id="brand-image" @change="logo" type="file" hidden>
                            </label>
                        </div>
                    </div>
                    <div class="w-2/3 pl-2">
                        <div class="w-full">
                            <label for="brand-banner" class="text-sm block mb-2">Brand Banner</label>
                            <label for="brand-banner" class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                                <img v-if="bannerImg" :src="bannerImg" class="w-full h-full rounded-md">
                                <div v-if="!bannerImg" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-common text-5xl opacity-85" />
                                    <span class="text-common font-semibold opacity-85">Upload Brand Banner</span>
                                </div>
                                <input id="brand-banner" @change="banner" type="file" hidden>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <label for="description" class="text-sm block mb-2">Description</label>
                    <div class="editor_data">
                        <SummernoteEditor v-model="form.description" />
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <Button @click="onSubmit">Save Brand</Button>
            </div>
        </div>
    </AppLayout>
</template>
