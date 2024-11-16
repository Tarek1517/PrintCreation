<script setup>
    import { onMounted, ref } from 'vue';
    import useAxios from "@/composables/useAxios"
    import { toast } from 'vue3-toastify';
    import Pagination from '@/components/Pagination.vue'
    const { loading, error, sendRequest } = useAxios();

    const customers= ref(null);

    const getCustomers = async() => {
        const response = await sendRequest({
            method: 'get',
            url: '/v1/customer',
        });
        customers.value = response.data
    }

    const onDelete = async(id) => {
        const response = await sendRequest({
            method:'delete',
            url:`/v1/customer/${id}`,
        })

        if(response) {
            await getCustomers();
            toast.success('Customer Deleted Successfully');
        }
    }

    onMounted(() => {
        getCustomers();
    })
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <section class="text-sm font-normal shadow-lg rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        <Icon name="gis:globe-users" class="text-lg" />
                        <h3 class=" text-base font-medium">Customers</h3>
                    </div>
                    <div>
                        <Button class=" bg-common flex items-center gap-2">
                            <Icon name="material-symbols:add-box-outline" />
                            Add Record
                        </Button>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <Search />
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full  text-left rtl:text-right ">
              <thead class="uppercase bg-common">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Phone
                </th>
                <th scope="col" class="px-6 py-3">
                  Email
                </th>
                <th scope="col" class="px-6 py-3">
                  Address
                </th>
                <th scope="col" class="px-6 py-3">
                  Action
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="customer in customers?.data" class="hover:bg-secondary">
                <th scope="row" class="flex items-center px-6 py-4">
                  <div class="w-10 h-10 bg-purple-700 rounded-full flex items-center justify-center">
                    <span class="text-white text-xl">{{customer?.name?.substring(0,1)  }}</span>
                  </div>
                  <div class="ps-2">
                    <div class="text-sm font-semibold">{{customer?.name  }}</div>
                  </div>
                </th>
                <td class="px-6 py-4">
                  {{ customer?.phone }}
                </td>
                <td class="px-6 py-4">
                  {{ customer?.email }}
                </td>
                <td class="px-6 py-4">
                  {{ customer?.address?.name }}
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-2">
<!--                    <button class="w-8 h-8 rounded-md flex items-center justify-center bg-green-500 border border-green-900">-->
<!--                      <Icon  name="material-symbols:visibility-outline-rounded" class="text-xl text-white" />-->
<!--                    </button>-->
<!--                    <button class="w-8 h-8 rounded-md flex items-center justify-center bg-yellow-500 border border-yellow-900">-->
<!--                      <Icon name="material-symbols:edit-square-outline" class="text-lg text-white" />-->
<!--                    </button>-->
                    <button @click="onDelete(customer?.id)" class="w-8 h-8 rounded-md flex items-center justify-center bg-red-500 border border-red-900">
                      <Icon name="material-symbols:delete-outline" class="text-lg text-white" />
                    </button>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
            <Pagination v-if="customers?.data?.length > 0" :links="customers?.meta?.links" :from="customers?.meta?.from" :to="customers?.meta?.to"
                        :total="customers?.meta?.total"/>
          </div>
        </section>
    </AppLayout>
</template>
