<script setup>
    import { onMounted, ref , watch} from 'vue';
    import useAxios from "@/composables/useAxios"
    import Modal from '@/components/Modal.vue';
    import { toast } from 'vue3-toastify';
    const { loading, error, sendRequest } = useAxios();

    const review= ref(null);

    const products = ref(null);
    const getAllProducts = async() => {
        const response = await sendRequest({
            method:'get',
            url:'/v1/get-all-product-list',
        });
        if(response){
            products.value = response.data;
        }
    }

    const getReview = async () => {
        const response = await sendRequest({
            method: 'get',
            url: '/v1/review',
        });
        review.value = response?.data
    }
    const form = ref({
        product_id: null,
        name:null,
        rating: null,
        review: null,
        title:null,
        answer: null,
    });

    const onSubmit = async() => {
        const response = await sendRequest({
            method: 'post',
            url:'/v1/review',
            data: form.value,
        });
        if(response?.data){
            toast.success('Review Addded Succesfully', {autoclose:5000});
            getReview();
            isModalOpened.value = false;
        }
    }


    const newItem = ref({
        id:null,
        product_id: null,
        author_name:null,
        rating: null,
        review: null,
        title:null,
    })

    const editReview = (item) => {
        isEditModalOpened.value = true;
        newItem.value.id = item.id;
        newItem.value.author_name = item.author_name;
        newItem.value.product_id = item.product_id;
        newItem.value.rating = item.rating;
        newItem.value.review = item.review;
        newIttm.value.title = item.title;
    }

    const onUpdate = async(id) => {
        const response = await sendRequest({
            method: 'post',
            url: `/v1/review/${id}`,
            params: {
                _method: 'PUT'
            },
            data: newItem.value,
        });

        if(response?.data){
            toast.success( `Review Updated Succesfully`, {autoclose:5000});
            getReview();
            isEditModalOpened.value = false;
        }
    }


    const deleteReview = async(review) => {
        await sendRequest({
            method: 'delete',
            url: `/v1/review/${review}`,
        });

        getReview();
        toast.success('Review Deleted Succesfully', {autoClose:1000})
    }

    onMounted(() => {
        getReview();
        getAllProducts();
    })

    // model
    const isModalOpened = ref(false);
    const isEditModalOpened = ref(false);

    const openModal = () => {
    isModalOpened.value = true;
    };
    const closeModal = () => {
        isModalOpened.value = false;
        isEditModalOpened.value = false;
        form.value.author_name = null;
    };
</script>

<template>
    <Loading :value="loading" />
        <section class="bg-primary text-sm text-gray-300 font-normal border border-slate-600">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="simple-icons:nginxproxymanager" class="text-lg" />
                        <h3 class="text-base font-me">Prodcut Review</h3>
                    </div>
                    <div>
                        <button class="border border-common py-2 px-4 flex items-center gap-2 text-common" @click="openModal">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Review
                        </button>
                    </div>
                </div>

            </div>
          <div>
            <div class="relative overflow-x-auto">
              <table class="w-full text-left rtl:text-right">
                <thead class=" uppercase bg-secondary">
                <tr>
                  <th scope="col" class="px-6 py-3">
                    Product
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Review
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Rating
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Action
                  </th>
                </tr>
                </thead>

                <tbody>
                <tr  v-for="item in review" class="hover:bg-secondary">
                  <td class="px-6 py-4  ">
                    <div class="flex gap-2 max-w-xs">
                        <img :src="item?.product?.cover_image" class="w-12 rounded h-auto">
                        <h3>{{ item?.product?.title }}</h3>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class-="max-w-xs">
                        {{ item?.review }}
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="flex items-center gap-2 text-common">
                        <Icon class="text-xl" :name=" item.rating < star ? 'carbon:star' : 'carbon:star-filled'" v-for="star in 5" />
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    {{ item?.author_name }}
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">

                      <!-- <button @click="editVariation(item)" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                        <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />
                      </button> -->
                      <div>

                      </div>
                      <button @click="deleteReview(item?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                        <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                      </button>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>


    <Modal title="Add New Attribute" :isOpen="isModalOpened" @modal-close="closeModal">
        <div class="flex flex-col gap-5 pt-5">
            <div class="w-full">
                <label for="name" class="block text-sm mb-1">Select Product</label>
                <Select
                        label="title"
                        v-if="products"
                        :options="products"
                        :reduce="item => item.id"
                        :searchable="true"
                        v-model="form.product_id"
                        placeholder="Select Product"
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
                <label for="rating" class="block text-sm mb-1">Rating</label>
                <div class="rating">
                    <input v-model="form.rating" type="radio" id="star5" name="rating" value="5" />
                    <label class="star" for="star5" title="Awesome" aria-hidden="true">
                        <Icon name="carbon:star" />    
                        <!-- carbon:star-filled -->
                    </label>
                    <input v-model="form.rating" type="radio" id="star4" name="rating" value="4" />
                    <label class="star" for="star4" title="Great" aria-hidden="true">
                        <Icon name="carbon:star" /> 
                    </label>
                    <input v-model="form.rating" type="radio" id="star3" name="rating" value="3" />
                    <label class="star" for="star3" title="Very good" aria-hidden="true">
                        <Icon name="carbon:star" /> 
                    </label>
                    <input v-model="form.rating" type="radio" id="star2" name="rating" value="2" />
                    <label class="star" for="star2" title="Good" aria-hidden="true">
                        <Icon name="carbon:star" /> 
                    </label>
                    <input v-model="form.rating" type="radio" id="star1" name="rating" value="1" />
                    <label class="star" for="star1" title="Bad" aria-hidden="true">
                        <Icon name="carbon:star" /> 
                    </label>
                </div>
            </div>
            <div class="w-full">
                <label for="review" class="block text-sm mb-1">Review Message</label>
                <textarea v-model="form.review" class="w-full h-20 rounded border border-gray-600 bg-transparent text-gray-300"></textarea>
            </div>
            <div class="w-full">
                <label for="author_name" class="text-sm block mb-1">Author Name</label>
                <input v-model="form.author_name" type="text" class="w-full">
            </div>
            <div class="w-full">
                <label for="author_name" class="text-sm block mb-1">Answer</label>
                <input v-model="form.answer" type="text" class="w-full">
            </div>
            <div class="w-full">
                <Button @click="onSubmit">Save Variations</Button>
            </div>
        </div>
    </Modal>

    <Modal title="Edit Attribute" :isOpen="isEditModalOpened" @modal-close="closeModal">
        <div class="flex flex-col gap-5 pt-5">
            <div class="w-full">
                <label for="name" class="block text-sm mb-1">Variation Name</label>
                <input v-model="newItem.name" type="text" class="p-2 border border-primary rounded-md w-full">
            </div>
            
            <div class="w-full">
                <Button @click="onUpdate(newItem.id)">Update Variation</Button>
            </div>
        </div>
    </Modal>
</template>

<style scoped>
    .rating {
    border: none;
    float: left;
}

.rating > label {
    color: rgba(192, 188, 188, 0.94);
    float: right;
    margin-left: 5px;
}
.rating > label > svg {
    font-size: 32px;
}

.rating > input {
    display: none;
}

.rating > input:checked ~ label,
.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
        color: #E50102;
}

.rating > input:checked + label:hover,
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label,
.rating > input:checked ~ label:hover ~ label {
    color: #E50102;
}
</style>