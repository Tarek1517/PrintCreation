<script setup>
const props = defineProps({
  data:Object,
})
</script>
<template>
    <div class="mb-10 shadow bg-primary border border-slate-600">
      <h3 class="p-3 text-base font-medium  ">Recent Order</h3>
      <div class="relative overflow-x-auto">
        <table class="w-full text-sm  text-left rtl:text-right">
          <thead class="text-xs  uppercase bg-common">
          <tr>
            <th scope="col" class="px-6 py-3">
              Order Id
            </th>
            <th scope="col" class="px-6 py-3">
              Customer
            </th>
            <th scope="col" class="px-6 py-3">
              Price
            </th>
            <th scope="col" class="px-6 py-3">
              Order Type
            </th>
            <th scope="col" class="px-6 py-3">
              Payment Status
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(order, i) in data" class="hover:bg-secondary">
            <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap">
              {{order?.order_id}}
            </th>
            <th scope="row" class="flex items-center px-6 py-4 whitespace-nowrap">
              <div class="w-8 h-8 bg-purple-700 rounded-full flex items-center justify-center">
                <span class="text-base">{{order?.customer_name?.substring(0,1)}}</span>
              </div>
              <div class="ps-2">
                <div class="font-semibold">{{order?.customer_name}}</div>
                <div class="font-normal text-xs">{{order?.customer_phone}}</div>
              </div>
            </th>
            <td class="px-6 py-4">
              {{order?.grand_total}}
            </td>
            <td class="px-6 py-4">
              {{order?.order_type}}
            </td>
            <td class="px-6 py-4">
              {{order?.payment_status}}
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
</template>