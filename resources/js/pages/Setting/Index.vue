<script setup>
import { onMounted, ref } from 'vue';
import SummernoteEditor from 'vue3-summernote-editor';
import useAxios from '@/composables/useAxios';
import { toast } from 'vue3-toastify';
import Modal from '@/components/Modal.vue';

const {loading, error, sendRequest} = useAxios();

const getAllSetting = async() => {
    const response = await sendRequest({
        method:'get',   
        url:'/v1/setting',
    });
    setting.value.header_categories = response.data.header_categories;
    setting.value.currency = response.data.currency;
    setting.value.currency_symbol = response.data.currency_symbol;
    setting.value.email = response.data.email;
    setting.value.phone_number = response.data.phone_number;
    setting.value.whatsapp_number = response.data.whatsapp_number;
    setting.value.hotline_number = response.data.hotline_number;
    setting.value.facebook_link = response.data.facebook_link;
    setting.value.instagram_link = response.data.instagram_link;
    setting.value.youtube_link = response.data.youtube_link;
    setting.value.linkedin_link = response.data.linkedin_link;
    setting.value.app_name = response.data.app_name;
    setting.value.app_url = response.data.app_url;
	setting.value.home_products = response.data.home_products;
	setting.value.top_categories = response.data.top_categories;
}

// get Category
const categories = ref(null);
const getCategory = async() => {
    const response = await sendRequest({
        method:'get',
        url:'/v1/get-all-category-list',
    });
    if(response) {
        categories.value = response.data;
    }
}

//get Product
const products = ref(null);
const getProduct = async() => {
    const response  = await sendRequest({
        method:'get',
        url:'/v1/product',
    });
    if(response){
        products.value = response.data;
    }
}

// get Page
const pages = ref(null);
const getPage = async() => {
    const response = await sendRequest({
        method:'get',
        url:'/v1/all-page-list',
    });

    if(response) {
        pages.value = response.data;
    }
}

const tabs = [
    'App',
    'Header',
	'Home',
    'Footer',
];
const activeTab = ref(0);

const setting = ref({
    header_categories: [],
	home_products: null,
	top_categories: null,
    currency:null,
    currency_symbol: null,
    email: null,
    phone_number: null,
    whatsapp_number: null,
    hotline_number: null,
    facebook_link: null,
    youtube_link: null,
    instagram_link: null,
    linkedin_link: null,
    app_name: null,
});


const onSubmit = async() => {
    const response = await sendRequest({
        method:'post',
        url:'/v1/save-header-setting',
        data: setting.value,
    });

    if(response) {
        toast.success('Setting saved Successfully');
        getAllSetting();
    }
}

const footer_columns = ref(null);
const getFooter = async () => {
    const response = await sendRequest({
        method:'get',
        url:'/v1/footer',
    })

    if(response){
        footer_columns.value = response.data
    }
}

const form = ref({
    title:null,
    pages:null,
    content:null,
    width:null,
    order_number:null
});

const resetForm = () => {
    title.value=null;
    pages.value=null;
    content.value=null;
    order_number.value=null;
}

const onFooterSubmit = async() => {
    const response = await sendRequest({
        method:'post',
        url:'/v1/footer',
        data: form.value,
    })
    if(response) {
        toast.success('Footer save successfully');
        getFooter();
        isModalOpened.value = false;
        resetForm();
    }
}


const onFooterDelete = async(id) => {
    const response = await sendRequest({
        method:'delete',
        url:`/v1/footer/${id}`,
    })
    if(response){
        toast.success('Footer Column Deleted Successfully');
        getFooter();
    }
}


// model
    const isModalOpened = ref(false);

    const openModal = () => {
    isModalOpened.value = true;
    };
    const closeModal = () => {
        isModalOpened.value = false;
    };

onMounted(() => {
    getCategory();
    getPage();
    getAllSetting();
    getFooter();
    getProduct();
})
</script>
<template>
    <Loading :value="loading" />

        <section>
            <div class="  p-4">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-2">
                        <Icon name="material-symbols:settings-outline-rounded" class="text-lg" />
                        <h3 class="text-base font-medium">Setting</h3>
                    </div>
                </div>

                <div class="flex space-x-2">
                    <div class="w-1/5">
                        <ul class="border border-common rounded overflow-hidden">
                            <li  v-for="(tab, index) in tabs" :key="index">
                                <button
                                    @click="activeTab = index"
                                    :class="[ 'px-4 py-2  w-full border-b border-common', activeTab === index ? ' bg-common      ' : 'text-black',
                                    ]"
                                >
                                {{ tab }}
                            </button>
                            </li>
                            
                        </ul>
                    </div>
                    <div class="w-4/5">
                        <div class="w-full border border-common rounded p-2">
                            <div class="w-full flex flex-wrap" v-if="activeTab === 0">
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">App Url</label>
                                    <input v-model="setting.app_url" readonly type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">App Name</label>
                                    <input v-model="setting.app_name" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">Hotline Number</label>
                                    <input v-model="setting.hotline_number" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">Phone Number</label>
                                    <input v-model="setting.phone_number" type="text" class="p-2 rounded-md w-full" />
                                </div>
                              <div class="w-1/2 px-2 mb-2">
                                <label for="app-url" class="text-xs mb-1 block">Whatsapp Number</label>
                                <input v-model="setting.whatsapp_number" type="text" class="p-2 rounded-md w-full" />
                              </div>
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">Email</label>
                                    <input v-model="setting.email" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                  <label for="app-url" class="text-xs mb-1 block">Facebook</label>
                                  <input v-model="setting.facebook_link" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                  <label for="app-url" class="text-xs mb-1 block">Instagram</label>
                                  <input v-model="setting.instagram_link" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                  <label for="app-url" class="text-xs mb-1 block">Linked In</label>
                                  <input v-model="setting.linkedin_link" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                  <label for="app-url" class="text-xs mb-1 block">Youtube</label>
                                  <input v-model="setting.youtube_link" type="text" class="p-2 rounded-md w-full" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">Currency</label>
                                    <input type="text" class="p-2 rounded-md w-full" v-model="setting.currency" />
                                </div>
                                <div class="w-1/2 px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">Currency Symbol</label>
                                    <input type="text" class="p-2 rounded-md w-full" v-model="setting.currency_symbol" />
                                </div>
                                <div class="w-full px-2 mb-2">
                                    <label for="app-url" class="text-xs mb-1 block">Chat Script</label>
                                    <textarea class="p-2 w-full focus:outline-none focus:ring-0 focus:border-common rounded ring-0 bg-secondary border border-common shadow-md shadow-common/50 transition-all ease-in-out duration-100"></textarea>
                                </div>

                                <div class="w-full mt-5">
                                    <Button @click="onSubmit" class="rounded">Save Header Setting</Button>
                                </div>
                            </div>

                            <div class="w-full flex flex-wrap gap-4" v-if="activeTab === 1">
                                <div class="w-full">
                                    <label for="header-category" class="text-xs mb-1 block">Header Category</label>
                                    <Select
                                        v-if="categories"
                                        label="name"
                                        :options="categories"
                                        :reduce="item => item.id"
                                        v-model="setting.header_categories"
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
                                    <Button @click="onSubmit" class="rounded">Save Header Setting</Button>
                                </div>
                            </div>
							<div class="w-full flex flex-wrap gap-4" v-if="activeTab === 2">
								<div class="w-full">
                                    <label for="header-category" class="text-xs mb-1 block">Select Our Products</label>
                                    <Select
                                        v-if="products"
                                        label="title"
                                        :options="products?.data"
                                        :reduce="item => item.id"
                                        v-model="setting.home_products"
                                        multiple
                                    >
                                    <template v-slot:option="option">
                                        <li class="flex items-start py-1">
                                            <div class="flex items-center justify-between w-full">
                                                <div class="me-1 flex items-center gap-2">
                                                    <img :src="option?.cover_image" class="w-12 h-12">
                                                    <h6 class="mb-25">{{ option?.title }}</h6>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                    </Select>
                                </div>
								 <div class="w-full">
                                    <label for="header-category" class="text-xs mb-1 block">Top Categories</label>
                                    <Select
                                        v-if="categories"
                                        label="name"
                                        :options="categories"
                                        :reduce="item => item.id"
                                        v-model="setting.top_categories"
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
                                    <Button @click="onSubmit" class="rounded">Save Setting</Button>
                                </div>
							</div>
                            <div class="w-full " v-if="activeTab === 3">
                                <div class="flex items-center justify-between mb-2">
                                    <h3>Footer</h3>
                                    <button class="text-xs  bg-common px-3 py-1.5 rounded" @click="openModal">Add New</button>
                                </div>
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right">
                                        <thead class="text-xs  uppercase bg-common">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Column Title
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
                                            
                                            <tr v-for="column in footer_columns" class="hover:bg-secondary">
                                                <td class="px-6 py-4">
                                                    {{ column?.title }}
                                                </td>
                                                <th class="px-6 py-4">
                                                    {{ column?.order_number }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-2">
                                                        <!-- <button  class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                                                            <Icon name="material-symbols:edit-square-outline" class="text-lg      " /> 
                                                        </button> -->
                                                        <button @click="onFooterDelete(column?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                                                            <Icon name="material-symbols:delete-outline" class="text-lg      " />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <Modal title="Add New Footer Column" :isOpen="isModalOpened" @modal-close="closeModal">
        <div class="flex flex-col gap-2">
            <div class="w-full">
                <label for="title" class="text-xs block mb-1">Column Title</label>
                <input type="text" class="p-2 rounded border w-full" v-model="form.title">
            </div>
            <div class="w-full">
                <label for="title" class="text-xs block mb-1">Column Pages</label>
                <Select
                    v-if="pages"
                    label="title"
                    :options="pages"
                    :reduce="item => item.id"
                    multiple
                    v-model="form.pages"
                >

                </Select>
            </div>
            <div class="full flex space-x-2">
                <div class="w-1/2">
                    <label for="title" class="text-xs block mb-1">Order Number</label>
                    <input type="text" class="p-2 rounded border w-full" v-model="form.order_number">
                </div>
            </div>
            <div class="w-full">
                <label for="title" class="text-xs block mb-1">Column Content</label>
                <div class="editor_data footer-content">
                    <SummernoteEditor v-model="form.content" />
                </div>
            </div>
            <div class="w-full mt-5">
                <Button @click="onFooterSubmit" class="w-full">Save Footer Column</Button>
            </div>
        </div>
    </Modal>
</template>
