<script setup>
import {onMounted, ref} from 'vue';
import useAxios from '@/composables/useAxios';
import { toast } from 'vue3-toastify';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const {loadin, error, sendRequest} = useAxios();

const getSection = async() => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/home-section/${route?.params?.id}`,
    })
    if(response) {
        form.value.title = response.data.title;
        form.value.sub_title = response.data.sub_title;
        form.value.categories = response.data.categories;
        form.value.products = response.data.products;
        form.value.order_number = response.data.order_number;
        bannerImg.value = response.data.banner;
    }
}

const products = ref(null);
const getProducts = async() => {
    const response = await sendRequest({
        method: 'get',
        url:'/v1/get-all-product-list',
    });

    products.value = response.data;
}

const categories = ref(null);
const getCategory = async() => {
    const response = await sendRequest({
        method: 'get',
        url: '/v1/get-all-category-list',
    })

    categories.value = response.data
}


const bannerImg = ref(null);
const image = (image) => {
    const file = image.target.files[0];
    form.value.banner = file;
    bannerImg.value = URL.createObjectURL(file);
}

const form = ref({
    title:null,
    sub_title:null,
    banner:null,
    categories: [],
    products: [],
    order_number:null
})

const onSubmit = async() => {
    const response = await sendRequest({
        url:`/v1/home-section/${route.params.id}`,
        method: 'post',
        data:form.value,
        params: {
            _method: 'PUT'
        },
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })

    if(response){
        toast.success('Home Section Updated Successfully');
        router.push('/home-sections')
    }
}

onMounted(() => {
    getSection();
    getProducts();
    getCategory();
})
</script>

<template>
    <Loading :value="loading" />
    <AppLayout>
        <div class="p-4 shadow-lg rounded-lg flex flex-col gap-5 w-full max-w-3xl mx-auto">
            <h3>Create Home Section</h3>
            <div class="w-full">
                <label for="title" class="text-xs mb-1 block">Title</label>
                <input v-model="form.title" type="text" class="rounded-md border p-2 w-full">
            </div>
            <div class="w-full">
                <label for="sub_title" class="text-xs mb-1 block">Sub Title</label>
                <textarea v-model="form.sub_title" class="p-2 w-full focus:outline-none focus:ring-0 focus:border-common rounded ring-0 bg-secondary border border-common focus:shadow-md focus:shadow-common/50 transition-all ease-in-out duration-100"></textarea>
            </div>

            <div class="w-full">
                <label for="order_number" class="text-xs mb-1 block">Order Number</label>
                <input v-model="form.order_number" type="text" class="rounded-md border p-2 w-full">
            </div>
            <div class="w-full">
                <label for="title" class="text-xs mb-1 block">Categories</label>
                <Select
                    label="name"
                    v-if="categories"
                    :options="categories"
                    :reduce="item => item.id"
                    :searchable="true"
                    v-model="form.categories"
                    placeholder="Select Categories..."
                    multiple
                >
                <template v-slot:option="option">
                    <li class="flex items-start py-1">
                        <div class="flex items-center justify-between w-full">
                            <div class="me-1 flex items-center gap-2">
                                <img :src="option?.icon" class="w-12 h-12">
                                <h6 class="mb-25">{{ option?.name }}</h6>
                            </div>
                        </div>
                    </li>
                </template>
                </Select>
            </div>
            <div class="w-full">
                <label for="title" class="text-xs mb-1 block">Products</label>
                <Select
                    label="title"
                    v-if="products"
                    :options="products"
                    :reduce="item => item.id"
                    :searchable="true"
                    v-model="form.products"
                    placeholder="Select Products..."
                    multiple
                >
                <template v-slot:option="option">
                    <li class="flex items-start py-1">
                        <div class="flex items-center justify-between w-full">
                            <div class="me-1 flex items-center gap-2">
                                <img :src="option?.cover_image" class="w-16 h-16 object-cover">
                                <h6 class="mb-25">{{ option?.title }}</h6>
                            </div>
                        </div>
                    </li>
                </template>
                </Select>
            </div>
            <div class="w-full">
                <Button class="w-full rounded-md" @click="onSubmit">Save Section</Button>
            </div>
        </div>
    </AppLayout>
</template>