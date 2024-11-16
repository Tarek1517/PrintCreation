<script setup>
import useAxios from "@/composables/useAxios";
import {onMounted, ref } from "vue";
import { useRoute} from "vue-router";
const { sendRequest, loading, error } = useAxios();
const route = useRoute();

const printInvoice = (areaID) =>{
  var printContent = document.getElementById(areaID).innerHTML;
  var originalContent = document.body.innerHTML;
  document.body.innerHTML = printContent;
  window.print();
  document.body.innerHTML = originalContent;
}

const order = ref(null)
const getOrder = async () => {
  const response = await sendRequest({
    method: 'get',
    url: `/frontend/v1/show-customer-order/${route?.params?.id}`,
  });

  if(response) {
    order.value = response.data;
  }
}

onMounted(() => {
  window.scrollTo(0,0)
  getOrder();
})
</script>

<template>
  <section class=" overflow-hidden py-5">
    <button class="bg-common px-2 py-1 text-white" @click="printInvoice('areaOfPrient')">Print Invoice</button>

    <div class="w-full bg-white max-w-4xl mx-auto p-3" id="areaOfPrient">
      <div class="border border-gray-300 py-20 px-5" >
        <div>
          <img class="w-32 h-auto" src="https://itradelinks.ctpse.info/images/logoo.png">
        </div>
        <div class="flex justify-between pb-10">
          <div>
            <h3>Invoice To</h3>
            <ul>
              <li>Name: {{ order?.customer?.name ?? order?.customer_name}}</li>
              <li>Phone: {{ order?.customer?.phone ?? order?.customer_phone}}</li>
              <li>Email: {{ order?.customer?.email }}</li>
            </ul>
          </div>
          <div>
            <h3>{{ order?.order_id }}</h3>
            <ul>
              <li>Order Date: {{ order?.order_date }}</li>
              <li>Order Status: {{ order?.order_status }}</li>
              <li>Payment Status: {{ order?.payment_status }}</li>
            </ul>
          </div>
        </div>


        <!-- Invoice Description starts -->
        <table class="table w-full border py-10">
          <thead>
          <tr class="border">
            <th class="py-1">Product Name</th>
            <th class="py-1">Price</th>
            <th class="py-1">size & Qty</th>
            <th class="py-1">Total</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, index) in  order?.order_details" :key="`single-details-item-${index}`">
            <td class="py-1 text-center">
              {{ item?.product?.title+"-"+item?.stock?.varient?.replace(/\//g, '-').slice(0, -1).slice(0, 20) }}...
            </td>
            <td class="py-1 text-center">
              <span class="fw-bold">{{ item?.stock?.price ?? item?.product?.price }}</span>
            </td>
            <td class="py-1 text-center">
                    <span class="fw-bold">
                        {{ item?.quantity }}
                    </span>
            </td>
            <td class="py-1 text-center">
                    <span class="fw-bold">
                        {{ (item?.stoke?.price ?? item?.product?.price) * item?.quantity }}
                    </span>
            </td>
          </tr>
          </tbody>
        </table>

        <div class="flex justify-end pt-20">
          <div class="w-4/12">
            <div v-if="order?.sub_total" class="flex w-full justify-between items-center">
              <p>Sub Total</p>
              <p>{{ order?.sub_total }}</p>
            </div>
            <div class="flex w-full justify-between items-center border-b">
              <p>Delivery Charge</p>
              <p v-if="order?.address?.area">${{ order?.address?.area?.delevery_charge }}</p>
              <p v-else>{{order?.delivery_charge}}</p>
            </div>
            <div class="flex w-full justify-between items-center pt-2">
              <p class="font-semibold">Grand Total</p>
              <p class="font-semibold">{{ order?.grand_total }}</p>
            </div>
          </div>
        </div>


        <div class="pt-20">
          <h3 class="text-lg">Thank You for Your Purchase!</h3>
          <p class="text-xs">We appreciate your business and hope you enjoy your new products. If you have any questions or need assistance, please don't hesitate to contact our customer support team.</p>
        </div>
      </div>
    </div>

  </section>
</template>

<style lang="sass">

</style>