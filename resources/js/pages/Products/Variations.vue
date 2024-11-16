<script setup>
    import { onMounted, ref , watch} from 'vue';
    import useAxios from "@/composables/useAxios"
    import Modal from '@/components/Modal.vue';
    import { toast } from 'vue3-toastify';
    const { loading, error, sendRequest } = useAxios();

    const variations= ref(null);

    const query = ref({
        search:null,
        parPage:20,
    });

    const getVariation = async () => {
        console.log(query?.value);
        const response = await sendRequest({
            method: 'get',
            url: '/v1/variation',
            data:query.value
        });
        variations.value = response?.data
    }

    const iconImg = ref(null);
    const image = (image) => {
        const file = image.target.files[0];
        form.value.image = file;
        newItem.value.image = file;
        iconImg.value = URL.createObjectURL(file);
    }
    // Add new Varaton
    const form = ref({
        name:null,
        image:null,
    });

    const onSubmit = async() => {
        const response = await sendRequest({
            method: 'post',
            url:'/v1/variation',
            data: form.value,
            headers: {
                'Content-type' : 'multipart/form-data'
            }
        });
        if(response?.data){
            toast.success( `${response?.data?.name} Variation Addded Succesfully`, {autoclose:1000});
            getVariation();
            isModalOpened.value = false;
        }
    }

    // edit product
    const newItem = ref({
        id:null,
        name:null,
        image:null,
    })

    const editVariation = (item) => {
        isEditModalOpened.value = true;
        newItem.value.id = item.id
        newItem.value.name = item.name
        iconImg.value = item.image
    }

    const onUpdate = async(id) => {
        const response = await sendRequest({
            method: 'post',
            url: `/v1/variation/${id}`,
            params: {
                _method: 'PUT'
            },
            data: newItem.value,
            headers: {
                'Content-type' : 'multipart/form-data'
            }
        });

        if(response?.data){
            toast.success( `Variatioin Updated Succesfully`, {autoclose:1000});
            getVariation();
            isEditModalOpened.value = false;
        }
    }


    // delete Variation
    const deleteVariation = async(variation) => {
        await sendRequest({
            method: 'delete',
            url: `/v1/variation/${variation}`,
            headers: {
                'Content-type' : 'multipart/form-data'
            }
        });

        getVariation();
        toast.success('Variation Deleted Succesfully', {autoClose:1000})
    }


    onMounted(() => {
        getVariation();
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
        form.value.name = null;
        iconImg.value = null;
    };


watch(query, getVariation, {deep: true});
</script>

<template>
    <Loading :value="loading" />

        <section class="bg-primary text-sm shadow-lg rounded-lg ">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="simple-icons:nginxproxymanager" class="text-lg" />
                        <h3 class="text-base font-me">Prodcut Variations</h3>
                    </div>
                    <div>
                        <button class="border border-common py-2 px-4 flex items-center gap-2 bg-common" @click="openModal">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <Search />
                </div>
            </div>
          <div>
            <div class="relative overflow-x-auto">
              <table class="w-full text-left rtl:text-right">
                <thead class="uppercase bg-common">
                <tr>
                  <th scope="col" class="px-6 py-3">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Slug
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Image
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Created At
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Action
                  </th>
                </tr>
                </thead>

                <tbody>
                <tr  v-for="item in variations?.data" class="hover:bg-secondary">
                  <td class="px-6 py-4  ">
                    {{ item?.name }}
                  </td>
                  <td class="px-6 py-4">
                    {{ item?.slug }}
                  </td>
                  <td class="px-6 py-4">
                    <img class="w-20 h-auto object-cover" :src="item?.image">
                  </td>
                  <td class="px-6 py-4">
                    {{ item?.created_at }}
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">

                      <button @click="editVariation(item)" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                        <Icon name="material-symbols:edit-square-outline" class="text-lg    " />
                      </button>
                      <div>

                      </div>
                      <button @click="deleteVariation(item?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                        <Icon name="material-symbols:delete-outline" class="text-lg    " />
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
                <label for="name" class="block text-sm mb-1">Variation Name</label>
                <input v-model="form.name" type="text" class="p-2 border border-primary rounded-md w-full">
            </div>
<!--            <div class="w-full">-->
<!--                <label for="variation-img" class="text-sm block mb-2">Variation Image</label>-->
<!--                <label class="border border-primary border-dashed p-4 rounded-2xl flex items-center justify-center  w-32 h-32 cursor-pointer">-->
<!--                    <img v-if="iconImg" :src="iconImg" class="w-full h-full object-cover">-->
<!--                    <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">-->
<!--                        <Icon name="tabler:cloud-upload" class="text-primary text-2xl opacity-85" />-->
<!--                        <span class="text-primary text-xs font-semibold opacity-85">Upload Image</span>-->
<!--                    </div>-->
<!--                    <input id="category-icon" @change="image" type="file" hidden>-->
<!--                </label>-->
<!--            </div>-->
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

<!--            <div class="w-full">-->
<!--                <label for="update-variation-img" class="text-sm block mb-2">Variation Image</label>-->
<!--                  <label class="border border-common border-dashed p-4 rounded-2xl flex items-center justify-center  w-32 h-32 cursor-pointer">-->
<!--                    <img v-if="iconImg" :src="iconImg" class="w-full h-full object-cover">-->
<!--                    <div v-if="!iconImg" class="flex flex-col items-center justify-center gap-2">-->
<!--                        <Icon name="tabler:cloud-upload" class="text-primary text-2xl opacity-85" />-->
<!--                        <span class="text-common text-xs font-  semibold opacity-85">Upload Image</span>-->
<!--                    </div>-->
<!--                    <input id="update-banner-image" @change="image" type="file" hidden>-->
<!--                </label>-->
<!--            </div>-->
            
            <div class="w-full">
                <Button @click="onUpdate(newItem.id)">Update Variation</Button>
            </div>
        </div>
    </Modal>
</template>