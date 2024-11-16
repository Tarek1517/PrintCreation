<script setup>
    import  SummernoteEditor  from 'vue3-summernote-editor';
    import {ref, onMounted} from 'vue';;
    import useAxios from '@/composables/useAxios.js';
    import {useRouter} from 'vue-router';
    import { useRoute } from 'vue-router';
    import { toast } from 'vue3-toastify';

    const {error, loading, sendRequest} = useAxios();
    const router = useRouter();
    const route = useRoute();

    const img = ref(null);
    const image = (image) => {
        const file = image.target.files[0];
        form.value.seo_image = file;
        img.value = URL.createObjectURL(file);
    }

    const getPage = async() => {
        const response = await sendRequest({
            method:'get',
            url:`/v1/page/${route?.params?.id}`,
        });

        if(response){
            form.value.id = response.data.id
            form.value.title = response.data.title
            form.value.content = response.data.content
        }
    }

    const form = ref({
        id:null,
        title:null,
        content:'',
    })

    const onUpdate = async(id) => {
        const response = await sendRequest({
            method:'post',
            url:`/v1/page/${id}`,
            params: {
                _method:'PUT'
            },
            data:form.value
        })

        if(response) {
            toast.success('New Page Addded Successfully', {autoClose:1000})
            router.push('/pages')
        }
    }

    onMounted(() => {
        getPage();
    })
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <div class="flex justify-center">
            <div class="w-full pr-1">
                <div class=" p-4 shadow-lg rounded-lg">
                    <h3>Create New Page</h3>
                    <div class="mb-5">
                        <label for="title" class="mb-1 block text-sm">Page Title</label>
                        <input id="title" type="text" class="p-2 rounded-md border w-full" v-model="form.title">
                    </div>
                    <div>
                        <label for="summery" class="mb-1 block text-sm">Page Content</label>
                        <div class="editor_data">
                        <SummernoteEditor v-model="form.content" />
                    </div>
                    </div>
                    <div class="mt-5">
                        <Button @click="onUpdate(form.id)">Update Page</Button>
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
    </AppLayout>
</template>