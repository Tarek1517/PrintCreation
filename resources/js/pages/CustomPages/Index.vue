<script setup>
    import { onMounted, ref } from 'vue';
    import useAxios from "@/composables/useAxios"
    import { toast } from 'vue3-toastify';

    const { loading, error, sendRequest } = useAxios();

    const pages= ref(null);

    const getPages = async() => {
        const response = await sendRequest({
            method: 'get',
            url: '/v1/page',
        });
        pages.value = response.data
    }

    const onDelete = async(id) => {
        const response = await sendRequest({
            method:'delete',
            url:`/v1/page/${id}`,
        })

        if(response){
            getPages();
            toast.success('Page Deleted Succesfully');
        }
    }

    onMounted(() => {
        getPages();
    })
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <section class="shadow-lg rounded-lg">
            <div class="p-4 ">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Icon name="gis:globe-users" class="text-lg" />
                        <h3 class="text-base font-medium">Pages</h3>
                    </div>
                    <div>
                        <RouterLink to="/create-page" class="flex items-center gap-2 bg-common px-4 py-2 text-sm">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </RouterLink>
                    </div>
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right">
              <thead class="text-xs  uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Slug
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
              <tr v-for="page in pages?.data" class="hover:bg-secondary">
                <td class="px-6 py-4">
                  {{ page?.title }}
                </td>
                <td class="px-6 py-4">
                  {{ page?.slug }}
                </td>
                <td class="px-6 py-4">
                  {{ page?.created_at }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
                    <RouterLink :to="`/edit-page/${page?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">
                      <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />
                    </RouterLink>
                    <button @click="onDelete(page?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
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
