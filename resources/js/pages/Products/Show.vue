<script setup>
import Gallary from "@/components/Gallary.vue";
import { ref, onMounted } from 'vue'
import  useAxios  from '@/composables/useAxios';
import { useRoute } from 'vue-router';

const { loading, error, sendRequest } = useAxios();
const route = useRoute();

const product = ref(null);

const getProduct = async() => {
    const response = await sendRequest({
        method:'get',
        url:`/v1/product/${route.params.slug}`,
    });

    product.value = reaponse.data;
}

onMounted(() => {
    getProduct();
})
</script>

<template>
    <Loading :value="loading" />
        <section>
            <div class="flex flex-col lg:flex-row mt-5 mx-6 bg-white shadow-lg p-5">
                <div class="w-full lg:w-[40%]">
                    <div>
                        <Gallary :images="product?.images"  :coverImg="product?.cover_image" />
                        
                    </div>
                </div>
                <div class="w-full lg:w-[50%] px-8">
                    <div>
                        <h3 class=" font-base text-md lg:text-2xl">{{ product?.title }}</h3>
                        <p class="my-4">
                            <span class="rounded bg-primary px-2 py-0.5 text-white text-sm font-medium"> In Stock </span>
                        </p>
                        <div v-for="attribute in product?.attributes">
                            <p>{{ attribute?.option?.name }}</p>
                            <div v-for="(tag, index) in attribute?.tags" :key="index">
                                <label class="radio-label d-flex align-items-center justify-content-center">
                                    <input class="d-none" type="radio" v-model="attribute.selectVariant" :name="attribute?.option?.name" :value="tag">
                                    <span class="radio-button">{{ tag }}</span>
                                </label>
                            </div>
                        </div>
                        <p class="text-xl lg:text-2xl">৳{{ product?.price }}</p>
                        
                    </div>
                </div>
            </div>
            
        </section>
</template>
