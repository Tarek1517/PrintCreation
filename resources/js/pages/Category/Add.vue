<script setup>
import  SummernoteEditor  from 'vue3-summernote-editor';
import useAxios from "@/composables/useAxios"
import { toast } from "vue3-toastify";
import { ref, onMounted } from "vue";
import { useRouter} from 'vue-router'
const { loading, error, sendRequest } = useAxios();
const router = useRouter();

const parentCategories = ref(null);
const getParentCategory = async() => {
    const response = await sendRequest({
        method:'get',
        url: '/v1/parent-category',
    });
    parentCategories.value = response?.data;
}

const iconImg = ref(null);
const bannerImg = ref(null);

const form = ref({
    name: null,
    parent_id: null,
    icon: null,
    banner: null,
    order_number: null,
    short_description: null,
    description: null,
});


const banner = (banner) => {
    const file = banner.target.files[0];
    form.value.banner = file;
    bannerImg.value = URL.createObjectURL(file);
}
const image = (image) => {
    const file = image.target.files[0];
    form.value.icon = file;
    iconImg.value = URL.createObjectURL(file);
}

const onSubmit = async() => {
    console.log(form.value);
    const response = await sendRequest({
        method: 'post',
        url: '/v1/category',
        data: form.value,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
    if(response?.data){
        toast.success( `${response?.data?.name} Category Addded Succesfully`, {autoclose:1000});
        await router.push('/category');
    }
}


onMounted(() => {
    getParentCategory()
})
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <div class="shadow-lg rounded-lg p-4 max-w-5xl mx-auto">
            <h3 class="mb-10">Create a New Category</h3>
            <div>
                <div class="flex items-center flex-wrap">
                    <div class="w-1/2 pr-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Category Name</label>
                            <input v-model="form.name" type="text" class="border border-primary rounded-md font-normal text-sm w-full">
                        </div>
                    </div>
                    
                    <div class="w-1/2 pl-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Parent Category</label>
                            <Select
                            v-if="parentCategories"
                            label="name"
                            :options="parentCategories"
                            :reduce="item => item.id"
                            v-model="form.parent_id"
                            >
                                
                            </Select>
                            <p v-else class="text-primary">Failed To load Parent Category...</p>
                        </div>
                    </div>
                    <div class="w-1/2 pr-2 pt-2">
                        <div class="w-full">
                            <label for="name" class="text-sm block mb-2">Order Number</label>
                            <input v-model="form.order_number" type="number" class="border border-primary rounded-md font-normal text-sm w-full">
                        </div>
                    </div>
                </div>
                <div class="flex items-center my-10">
                    <div class="w-1/3 pr-2">
                        <div class="w-full">
                            <label for="category-icon" class="text-sm block mb-2">Category Image</label>
                            <label class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                                <img v-if="iconImg" :src="iconImg" class="w-full h-full">
                                <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-common text-5xl opacity-85" />
                                    <span class="text-common font-semibold opacity-85">Upload Category Icon</span>
                                </div>
                                <input id="category-icon" @change="image" type="file" hidden>
                            </label>
                        </div>
                    </div>
                    <div class="w-2/3 pl-2">
                        <div class="w-full">
                            <label for="category-banner" class="text-sm block mb-2">Category Banner</label>
                            <label for="category-banner" class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center w-full h-52 cursor-pointer">
                                <img v-if="bannerImg" :src="bannerImg" class="w-full h-full rounded-md">
                                <div v-if="!bannerImg" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-common text-5xl opacity-85" />
                                    <span class="text-common font-semibold opacity-85">Upload Category Banner</span>
                                </div>
                                <input id="category-banner" @change="banner" type="file" hidden>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="w-full mb-4">
                    <label for="short-description" class="text-sm block mb-2">Short Description</label>
                    <textarea class="p-2 w-full focus:outline-none focus:ring-0 focus:border-common rounded ring-0 bg-secondary border border-common shadow-md shadow-common/50 transition-all ease-in-out duration-100 " v-model="form.short_description"></textarea>
                </div>
                <div class="w-full">
                    <label for="description" class="text-sm block mb-2">Description</label>
                    <div class="editor_data">
                        <SummernoteEditor v-model="form.description" />
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="bg-common           py-2 px-10" @click="onSubmit">Save Category</button>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>