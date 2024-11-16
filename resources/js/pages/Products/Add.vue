<script setup>
    import  SummernoteEditor  from 'vue3-summernote-editor';
    import { ref, onMounted } from 'vue'
    import  useAxios  from '@/composables/useAxios';
    import { useRouter } from 'vue-router';
    import { toast } from "vue3-toastify";

    const { loading, error, sendRequest } = useAxios();;
    const router = useRouter();


    //  get All brands and categories first
    const categories = ref(null);
    const brands = ref(null);

    // categores
    const getCategories = async() => {
        const response = await sendRequest({
            method:'get',
            url:'/v1/get-all-category-list',
        }); 
        categories.value = response?.data
    }

    // brands
    const getBrands = async() => {
      const response = await sendRequest({
        method:'get',
        url:'/v1/get-all-brand-list',
      });
      brands.value = response?.data
    }


    //handle cover image
    const coverImg = ref(null);
    const coverImage = (image) => {
        const file = image.target.files[0];
        form.value.cover_image = file;
        coverImg.value = URL.createObjectURL(file);
    }

    // handle hover image
    const hoverImg = ref(null);
    const hoverImage = (image) => {
        const file = image.target.files[0];
        form.value.hover_image = file;
        hoverImg.value = URL.createObjectURL(file);
    }
    

    // handle multiple image upload
    const handleFileChange = (event) => {
        for (let i = 0; i < event.target.files.length; i++) {
            form.value.images.push({
                url: URL.createObjectURL(event.target.files[i]),
                file: event.target.files[i],
            });
        }
    };

    const removeMedia = (index) => {
        let removedImage = form.value.images[index];
        if (removedImage.url.startsWith('blob:')) {
            URL.revokeObjectURL(removedImage.url);
        }
        form.value.images.splice(index, 1);
    };


    const form = ref({
        title: null,
        price: null,
        category_id: null,
        brand_id: null,
        video_url: null,
        sku: null,
        discount_price:null,
        stock:1,
        cover_image: null,
        hover_image: null,
        product_info: null,
        specification:null,
        images: [],
        key_features: [
            {
                name:null
            }
        ]
    });

    const addItem = () => {
        form.value.key_features.push({
            name: null,
        })
    }
    const removeItem = (index) => form.value.key_features.splice(index, 1);

    // Save Product
    const onSubmit = async() => {
        const response = await sendRequest({
            method: 'post',
            url: '/v1/product',
            data: form.value,
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        if(response?.data){
            toast.success( `${response?.data?.name} Product Addded Succesfully`, {autoclose:1000});
            await router.push('/products');
        }
    }

    onMounted(() => {
        getCategories();
      getBrands();
    });
</script>
<template>

    <Loading :value="loading" />
        <div class="p-4 shadow-lg rounded-lg">
            <h3 class="text-sm mb-5">Add New Product</h3>
            <div class="flex flex-wrap">
                <div class="w-1/2 flex flex-col gap-3 px-2">
                    <div class="w-full px-2">
                        <label for="title" class="text-xs mb-1">Product Title</label>
                        <input type="text" class="p-2 bg-secondary  border border-common w-full rounded" v-model="form.title" />
                    </div>
                    <div class="w-full flex flex-wrap">
                        <div class="w-1/2 px-2">
                            <label for="price" class="text-xs mb-1">Price</label>
                            <input type="number" class="p-2 bg-secondary  border border-common w-full rounded" v-model="form.price">
                        </div>
                        <div class="w-1/2 px-2">
                            <label for="discount" class="text-xs mb-1">Discount Price</label>
                            <input type="number" class="border border-primary p-2 rounded-md w-full" v-model="form.discount_price">
                        </div>
                        <div class="w-1/2 px-2">
                            <label for="sku" class="text-xs mb-1">Sku</label>
                            <input type="text" class="border border-primary p-2 rounded-md w-full" v-model="form.sku">
                        </div>
                        <div class="w-1/2 px-2">
                            <label for="discount" class="text-xs mb-1">Stock</label>
                            <input type="number" class="border border-primary p-2 rounded-md w-full" v-model="form.stock">
                        </div>
                        
                    </div> 
                    <div class="w-full flex items-center space-x-5 px-2">
                        <div class="w-1/2">
                            <label for="category" class="text-xs mb-1">Category</label>
                            <Select
                                label="name"
                                v-if="categories"
                                :options="categories"
                                :reduce="item => item.id"
                                :searchable="true"
                                v-model="form.category_id"
                                placeholder="Set Category"
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
                      <div class="w-1/2">
                        <label for="category" class="text-xs mb-1">Brand</label>
                        <Select
                            label="name"
                            v-if="brands"
                            :options="brands"
                            :reduce="item => item.id"
                            :searchable="true"
                            v-model="form.brand_id"
                            placeholder="Set Brand"
                        >
                          <template v-slot:option="option">
                            <li class="flex items-start py-1">
                              <div class="flex items-center justify-between w-full">
                                <div class="me-1 flex items-center gap-2">
                                  <img :src="option?.logo" class="w-12 h-12">
                                  <h6 class="mb-25">{{ option?.name }}</h6>
                                </div>
                              </div>
                            </li>
                          </template>
                        </Select>
                      </div>
                    </div>   
                    <div class="w-full px-2">
                        <label for="title" class="text-xs mb-1">Video Url (Optional)</label>
                        <textarea v-model="form.video_url" type="text" class="p-2 w-full focus:outline-none focus:ring-0 focus:border-common rounded ring-0 bg-secondary border border-common shadow-md shadow-common/50 transition-all ease-in-out duration-100"></textarea>
                    </div>
                    <div class="w-full px-2">
                        <label for="key-features" class="text-xs mb-1 block">Key Features</label>
                        <div class="flex items-end flex-wrap -mt-4" >
                            <div v-for="(item, index) in  form.key_features" class="w-4/5 pr-4 mt-4 flex items-center">
                                <input type="text" class="border rounded-md p-2 w-full" v-model="item.name">
                                <button @click="removeItem(index)" class="bg-slate-100 rounded w-8 h-8 flex items-center justify-center -ml-[36px] shadow" v-if="form.key_features.length > 1">
                                    <Icon name="material-symbols:close-rounded" class="text-common text-2xl"  />
                                </button>
                            </div>
                            <button class="w-1/5 text-xs bg-common rounded-md        py-3 px-4 text-nowrap" @click="addItem">Add More</button>
                        </div>
                    </div>
                </div>
                <div class="w-1/2 flex flex-col gap-4 px-2">
                    <div class="flex">
                        <div class="pr-2">
                            <label for="image" class="text-xs block mb-1">Cover Image</label>
                            <label for="cover_image" class="w-52 h-36 flex items-center bg-secondary
                            justify-center gap-3 p-2 border border-dashed border-common rounded-md text-common cursor-pointer">
                                <input type="file" id="cover_image" hidden @change="coverImage">
                                <img v-if="coverImg" :src="coverImg" class="w-full h-full object-cover">
                                <div v-else>
                                    <p class="text-xs">Upload Product Cover Image</p>
                                </div>
                            </label>
                        </div>
                      <div class="pl-2">
                        <label for="image" class="text-xs block mb-1">Hover Image</label>
                        <label for="hover_image" class="w-52 h-36 flex items-center bg-secondary
                            justify-center gap-3 p-2 border border-dashed border-common rounded-md text-common cursor-pointer">
                          <input type="file" id="hover_image" hidden @change="hoverImage">
                          <img v-if="hoverImg" :src="hoverImg" class="w-full h-full object-cover">
                          <div v-else>
                            <p class="text-xs">Upload Product Hover Image</p>
                          </div>
                        </label>
                      </div>
                    </div>
                    <div class="w-full">
                        <div class="p-2 bg-secondary border border-common rounded-lg">
                            <h4 class="mb-3 text-sm">Product Images</h4>
                            <ul class="mb-2">
                                <li class="text-xs">999 KB limit.</li>
                                <li class="text-xs">Allowed types: <span class="text-common"> JPG</span>, <span class="text-common">JPEG</span>, <span class="text-common">PNG</span>.</li>
                            </ul>
                            <div class="file-upload-container">
                                <div class="file-upload-container-wrapper">
                                    <!--IMAGES PREVIEW-->
                                    <div v-for="(image, index) in form.images"   class="file-upload-container-wrapper__preview" :key="image.index">
                                        <img :src="image.url" class="file-upload-container-wrapper__preview-item">
                                        <button @click="removeMedia(index)"  class="file-upload-container-wrapper__preview-cancel" type="button">
                                            <Icon name="material-symbols:close" class="text-common" />
                                        </button>
                                    </div>
                                    <!--UPLOAD BUTTON-->
                                    <div class="file-upload-container-wrapper__add">
                                        <label for="mu-file-input" class="file-upload-container__add-btn">
                                            <span>
                                                <Icon name="tabler:cloud-upload" />
                                            </span>
                                        </label>
                                        <input @change="handleFileChange" id="mu-file-input" type="file" accept="image/*" multiple hidden>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="w-full px-2 mb-5">
                    <label for="title" class="text-sm mb-1">Product Info</label>
                    <div class="editor_data bg-gray-100">
                        <SummernoteEditor v-model="form.product_info" />
                    </div>
                </div>
                <div class="w-full px-2">
                    <label for="title" class="text-sm mb-1">Specifications</label>
                    <div class="editor_data bg-gray-100">
                        <SummernoteEditor v-model="form.specification" />
                    </div>
                </div>
            </div>

        </div>
        <div class="text-center pt-10">
            <button class="w-1/2 mx-auto bg-common        py-2" @click="onSubmit">Save Product</button>
        </div>

</template>