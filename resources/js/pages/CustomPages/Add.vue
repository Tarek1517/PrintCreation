<script setup>
    import  SummernoteEditor  from 'vue3-summernote-editor';
    import {ref} from 'vue';
    import useAxios from '@/composables/useAxios.js';
    import {useRouter} from 'vue-router';
    import { toast } from 'vue3-toastify';

    const {error, loading, sendRequest} = useAxios();
    const router = useRouter();

    const img = ref(null);
    const image = (image) => {
    const file = image.target.files[0];
    form.value.seo_image = file;
    img.value = URL.createObjectURL(file);
}

    const form = ref({
        title:null,
        content:'',
        seo_title:null,
        seo_description:null,
        seo_image:null,
    })

    const onSubmit = async() => {
        const response = await sendRequest({
            method:'post',
            url:'/v1/page',
            data:form.value
        })

        if(response) {
            toast.success('New Page Added Successfully', {autoClose:1000})
            setTimeout(() =>{
              router.push('/pages');
            }, 2000);
        }
    }
</script>
<template>
    <Loading :value="loading" />
        <div class="flex justify-center">
            <div class="w-full pr-1">
                <div class="p-4 shadow-lg">
                    <h3>Create New Page</h3>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm">Page Title</label>
                        <input id="title" type="text" class="p-2 rounded-md border w-full" v-model="form.title">
                    </div>
                    <div>
                        <label for="summery" class="mb-1 block text-sm ">Page Content</label>
                        <div class="editor_data">
                        <SummernoteEditor v-model="form.content" />
                    </div>
                    </div>
                    <div class="mt-5">
                        <Button @click="onSubmit">Save Page</Button>
                    </div>
                </div>
            </div>
            <!-- <div class="w-1/5 pl-1">
                <div class=" bg-white p-4 shadow-lg">
                    <h3 class="mb-2">Page Seo Detail</h3>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm text-gray-600">Seo Title</label>
                        <input id="title" type="text" class="text-sm p-2 rounded-md border w-full" v-model="form.seo_title">
                    </div>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm text-gray-600">Seo Description</label>
                        <textarea class="p-1 w-full h-32 rounded-md text-sm" v-model="form.seo_description"></textarea>
                    </div>
                    <div>
                        <label for="title" class="mb-1 block text-sm text-gray-600">Seo Image</label>
                        <div class="w-full">
                            <label class="border border-primary border-dashed p-4 rounded-xl flex items-center justify-center w-full h-32 cursor-pointer" for="seo-image">
                                <img v-if="img" :src="img" class="w-full h-full object-cover">
                                <div v-if="!img" class="flex flex-col items-center justify-center gap-2">
                                    <Icon name="tabler:cloud-upload" class="text-primary text-4xl opacity-85" />
                                    <span class="text-primary font-normal text-base opacity-85">Upload Seo Image</span>
                                </div>
                                <input id="seo-image" @change="image" type="file" hidden>
                            </label>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
</template>