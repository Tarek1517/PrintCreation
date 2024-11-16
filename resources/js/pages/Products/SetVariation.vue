<script setup>
import useAxios from '@/composables/useAxios';
import { useRoute, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import { toast } from 'vue3-toastify';
const route = useRoute();
const router = useRouter();
const { loading, error, sendRequest } = useAxios();

const product = ref(null);
const variations = ref(null);

const form = ref({
    variationDivider: "/",
    varientSkuPrefix: "Ver-",
    defaultQty: 13,
    productName: null,
    defaultPrice: null,
    defaultStoke: null,
    variants: [],
    product_variant: [
        {
            option: null,
            tags: []
        }
    ],
    product_variant_prices: [],
    variationValues: [],
});

const getProduct = async () => {
    const response = await sendRequest({
        method: 'get',
        url: `/v1/product-variation/${route.params.slug}`,
    });
    product.value = response.data;
    populateForm();
};

const getAllVariantList = async () => {
    const response = await sendRequest({
        method: 'get',
        url: '/v1/product-variation',
    });
    variations.value = response.data;
};

const populateForm = () => {
    if (product.value) {
        form.value.productName = product.value.title;
        form.value.defaultPrice = product.value.price;
        form.value.product_variant = JSON.parse(product.value.variationOptions || '[]');
        form.value.product_variant_prices = product.value.stocks.map(stock => ({
            id: stock.id,
            title: stock.varient,
            price: stock.price,
            stock: stock.stock,
            sku: stock.sku,
            image: stock.image,
            imgPreview: stock.image ? `/path/to/image/${stock.image}` : null
        }));
    }
};

const checkVariant = () => {
    let tags = [];
    form.value.product_variant.forEach((item) => {
        tags.push(item.tags);
    });

    const newCombinations = getCombn(tags);
    const existingTitles = form.value.product_variant_prices.map(v => v.title);
    newCombinations.forEach(item => {
        if (!existingTitles.includes(item)) {
            form.value.product_variant_prices.push({
                title: item,
                price: product.value.discount_price && product.value.discount_price > 0 
                        ? product.value.discount_price 
                        : product.value.price,
                stock: 1,
                sku: form.value.varientSkuPrefix + item.replace(/\//g, '-'),
            });
        }
    });
};

const getCombn = (arr, pre = '') => {
    if (!arr.length) return [pre];
    return arr[0].reduce((result, value) => {
        return result.concat(getCombn(arr.slice(1), pre + value + '/'));
    }, []);
};

const image = (event, index) => {
    const file = event.target.files[0];
    if (file) {
        form.value.product_variant_prices[index].image = file;
        form.value.product_variant_prices[index].imgPreview = URL.createObjectURL(file);
    }
};

const storeVariation = async () => {
    const formData = new FormData();
    Object.keys(form.value).forEach(key => {
        if (Array.isArray(form.value[key])) {
            form.value[key].forEach((item, index) => {
                if (typeof item === 'object' && !(item instanceof File)) {
                    Object.keys(item).forEach(subKey => {
                        formData.append(`${key}[${index}][${subKey}]`, item[subKey]);
                    });
                } else {
                    formData.append(`${key}[${index}]`, item);
                }
            });
        } else {
            formData.append(key, form.value[key]);
        }
    });

    const response = await sendRequest({
        method: 'post',
        url: '/v1/product-variation',
        data: formData,
        params: {
            productSlug: route?.params.slug
        },
        headers: {
            'Content-Type': 'multipart/form-data'
        },
    });

    if (response) {
        toast.success('Variation Added Successfully');
        getProduct();
        setTimeout(() => {
          router.push('/products')
        },1000)
    }
};

const addNewVariant = () => {
    form.value.product_variant.push({ option: null, tags: [] });
};

const removeItem = (index) => {
    form.value.product_variant.splice(index, 1);
    checkVariant();
};

const deleteVariation = async (id, index) => {
    const response = await sendRequest({
        method: 'delete',
        url: `/v1/product-variation/${id}`,
    });

    if (response) {
        toast.success('Variation Deleted Successfully');
        form.value.product_variant_prices.splice(index, 1);
    }
};

onMounted(() => {
    getAllVariantList();
    getProduct();
});
</script>


<template>
    <Loading :value="loading" />
        <div class="flex space-x-2">
            <div class="w-1/6 mb-2">
                <div class="w-full bg-primary text-gray-300 border border-slate-600 shadow-lg p-2">
                    <img class="w-full h-auto" :src="product?.cover_image" />
                    <div class="mt-4">
                        <h3 class="text-sm">{{ product?.title }}</h3>
                        <p v-if="product?.discount_price"><strike class="mr-1 text-red-600">৳{{ product?.price }}</strike>৳{{ product?.discount_price }}</p>
                        <p v-else>৳{{ product?.price }}</p>
                    </div>
                </div>
            </div>
            <div class="w-5/6">
                <div class="w-full bg-primary border border-slate-500 shadow-lg p-4 mb-5">
                    <div class="flex mb-3" v-for="(item, index) in form.product_variant" :key="index">
                        <div class="w-3/12 pr-2">
                            <div class="w-full text-white">
                                <label for="variation">
                                    <span class="text-sm mb-1 block">Variation</span>
                                </label>
                                <Select
                                    v-if="variations"
                                    label="name"
                                    :options="variations"
                                    :reduce="item => item.id"
                                    v-model="item.option" 
                                    @change="checkVariant"
                                    placeholder="Select Variation.."
                                >

                                </Select>
                            </div>
                        </div>
                        <div class="w-9/12 pl-2">
                            <div class="w-full relative text-gray-300">
                                <button v-if="index > 0" @click="removeItem(index)" class="absolute top-0 right-1 bg-primary flex items-center text-xs justify-center w-6 h-5 rounded text-white">
                                    <Icon name="material-symbols:close-small-outline" class="text-xl text-white" />
                                </button>
                                <label class="text-sm mb-1 block">Variation Options</label>
                                <Select v-model="item.tags" @update:model-value="checkVariant" label="name" class="form-control" multiple taggable placeholder="Select Variation Options..."></Select>
                            </div>
                        </div>
                    </div>
                    <button @click="addNewVariant" class="mt-3 bg-common flex items-center gap-1 text-xs px-2 py-1 rounded text-white">
                        <Icon name="material-symbols:add" class="text-xl text-white" />
                        Add Variation
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full bg-primary shadow-lg border border-slate-600  pb-5" v-if="form.product_variant_prices.length > 0">
            <table class="w-full text-sm text-left ">
                <thead class="text-xs text-gray-300 uppercase bg-secondary">
                    <tr>
                        <th scope="col" class="px-16 py-3">Variant</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Stock</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(variant_price, index) in form.product_variant_prices" :key="index" class="text-gray-300 hover:bg-secondary">
                        <td class="p-4">{{ variant_price.title }}</td>
                        <td>
                            <input type="number" class="p-2 rounded-md border w-36" v-model="variant_price.price" />
                        </td>
                        <td>
                            <input type="number" class="p-2 rounded-md border w-32" v-model="variant_price.stock" />
                        </td>
                        <td>
                            <button v-if="variant_price?.id" @click="deleteVariation(variant_price?.id)" class="w-8 h-8 bg-primary rounded-md flex items-center justify-center">
                                <Icon name="material-symbols:delete-outline" class="text-white text-lg" />
                            </button>
                            <button v-else @click="deleteVariation(index)" class="w-8 h-8 bg-primary rounded-md flex items-center justify-center">
                                <Icon name="material-symbols:delete-outline" class="text-white text-lg" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center pt-5">
                <button class="bg-common text-white w-1/2 py-2" @click="storeVariation">Save</button>
            </div>
        </div>
</template>
