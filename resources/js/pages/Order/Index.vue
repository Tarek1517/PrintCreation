<script setup>
import {ref, onMounted } from 'vue';
import useAxios from '@/composables/useAxios';

const {loading, error, sendRequest} = useAxios();

const orders = ref(null);
const getOrder = async() => {
    const response = await sendRequest({
        method:'get',
        url:'/v1/order',
    })

    orders.value = response.data;
}

onMounted(() => {
    getOrder();
})
</script>
<template>
    <Loading :value="loading" />
    <section class="shadow-lg text-sm rounded-lg">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        <Icon name="material-symbols:shopping-cart-outline-sharp" class="text-lg" />
                        <h3 class="text-base font-medium">Order</h3>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                  <Search />
                </div>
            </div>
          <div class="relative overflow-x-auto">
            <table class="w-full text-left">
              <thead class="uppercase bg-common">
              <tr>
                <th scope="col" class="p-3">
                  Id
                </th>
                <th scope="col" class="p-3">
                  Customer
                </th>
                <th scope="col" class="p-3">
                  Total
                </th>
                <th scope="col" class="p-3">
                  Order Status
                </th>
                <th scope="col" class="p-3">
                  Type
                </th>
                <th scope="col" class="p-3">
                  Payment Status
                </th>
                <th scope="col" class="p-3">
                  Payment Method
                </th>
                <th scope="col" class="p-3">
                  Order date
                </th>
                <th scope="col" class="p-3">
                  Action
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="order in orders?.data" class="hover:bg-secondary">
                <th class="p-3">
                  <RouterLink :to="`/order-detail/${order?.id}`" class="text-common p-2 border border-common rounded-md">{{ order?.order_id }}</RouterLink>
                </th>
                <th scope="row" class="p-3">
                  <div class="flex items-center gap-2" v-if="order?.customer">
                    <div class="w-10 h-10 flex items-center justify-center bg-common   rounded-full text-white text-lg">
                      {{order?.customer?.name.substring(0, 1)}}
                    </div>
                    <div class="text-base font-semibold">{{ order?.customer?.name }}</div>
                  </div>
                  <div class="flex items-center gap-2" v-else>
                    <div class="w-8 h-8 flex items-center justify-center bg-common rounded-full font-normal text-white text-bse">
                      {{order?.customer_name.substring(0, 1)}}
                    </div>
                    <div class="font-normal">
                      <p class="text-sm mb-1">{{order?.customer_name}}</p>
                      <p class="text-xs">{{order?.customer_phone}}</p>
                    </div>
                  </div>
                </th>
                <td class="p-3">
                  <div class="flex items-center">
                      <p>{{ order?.grand_total }}</p>
                  </div>
                </td>
                <td class="p-3">
                  <div class="flex justify-center">
                    <p class="rounded  text-yellow-400 uppercase  text-xs font-medium px-3 py-1 text-center">{{ order?.order_status }}</p>
                  </div>
                </td>
                <td class="p-3">
                  <div class="flex items-center">
                    <p class="uppercase">{{ order?.order_type }}</p>
                  </div>
                </td>
                <td class="p-3">
                  <div class="flex justify-center">
                    <p class="rounded uppercase text-green-400 text-xs font-semibold px-3 py-1 text-center">{{ order?.payment_status }}</p>
                  </div>
                </td>
                <td class="p-3">
                  <div class="flex items-center uppercase">
                    <p>{{order?.payment_method}}</p>
                  </div>
                </td>
                <td class="p-3">
                  <div class="flex items-center">
                    <p>{{order?.order_date}}</p>
                  </div>
                </td>

                <td class="p-3">
                  <div class="flex items-center gap-2">
                    <RouterLink :to="`/order-detail/${order?.id}`" class="w-8 h-8 rounded-md flex items-center justify-center bg-green-500 border border-green-900">
                      <Icon  name="material-symbols:visibility-outline-rounded" class="text-xl text-white" />
                    </RouterLink>
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </section>
</template>
