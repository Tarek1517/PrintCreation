<script setup>
    import { onMounted, ref } from 'vue';
    import useAxios from "@/composables/useAxios"
    import { toast } from 'vue3-toastify';
    const { loading, error, sendRequest } = useAxios();

    const sections= ref(null);

    const getSection = async() => {
        const response = await sendRequest({
            method: 'get',
            url: '/v1/home-section',
        });
        sections.value = response.data
    }

    const onDelete = async(id) => {
        const response = await sendRequest({
            method:'delete',
            url:`/v1/home-section/${id}`,
        })

        if(response){
            await getSection();
            toast.success('Section Deleted Successfully');
        }
    }

    onMounted(() => {
        getSection();
    })
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <section class=" text-sm  shadow-lg rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="gis:globe-users" class="text-lg text-primary" />
                        <h3 class="text-base font-medium">Home Section</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-home-sections" class="flex items-center gap-2 px-4 py-2 border border-common bg-common">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-left rtl:text-right">
              <thead class="uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Title
                </th>
                <th scope="col" class="px-6 py-3">
                  Banner
                </th>
                <th scope="col" class="px-6 py-3">
                  Order Number
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
              <tr v-for="section in sections?.data" class="hover:bg-secondary">
                <td class="px-6 py-4">
                  {{ section?.title }}
                </td>
                <td class="px-6 py-4">
                  <img :src="section?.banner" class="w-20 h-auto">
                </td>
                <td class="px-6 py-4">
                  {{ section?.order_number }}
                </td>
                <td class="px-6 py-4">
                  {{ section?.created_at }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
                    <RouterLink :to="`/edit-section/${section?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                      <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />
                    </RouterLink>
                    <button @click="onDelete(section?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                      <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </section>
    </AppLayout>
</template>
