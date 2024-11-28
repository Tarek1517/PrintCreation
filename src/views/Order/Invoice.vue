<script setup>
import useAxios from "@/composables/useAxios";
import { useAuthStore } from "@/stores/useAuthStore";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const authStore = useAuthStore();
const { sendRequest, loading, error } = useAxios();
const route = useRoute();

const printInvoice = (areaID) => {
  var printContent = document.getElementById(areaID).innerHTML;
  var originalContent = document.body.innerHTML;
  document.body.innerHTML = printContent;
  window.print();
  document.body.innerHTML = originalContent;
};

const order = ref(null);
const getOrder = async () => {
  const response = await sendRequest({
    method: "get",
    url: `/frontend/v1/show-customer-order/${route?.params?.id}`,
    headers: {
      authorization: `Bearer ${authStore?.user?.token}`,
    },
  });

  if (response) {
    order.value = response.data;
  }
};

onMounted(() => {
  window.scrollTo(0, 0);
  getOrder();
});
</script>

<template>
  <section class="overflow-hidden lg:py-5 py-3">
    <div class="w-full max-w-4xl mx-auto p-3" id="areaOfPrient">
      <div class="flex justify-end">
        <button
          class="rounded my-3 right-2 bottom-1 px-2 py-2 bg-primary hover:bg-secondary"
          @click="printInvoice('areaOfPrient')"
        >
          <Icon
            icon="material-symbols-light:print-add"
            class="text-white lg:text-3xl text-xl"
          />
        </button>
      </div>
      <div class="border border-border rounded py-20 px-5">
        <div class="flex justify-between pb-10">
          <div>
            <h3 class="font-bold font-serif">Invoice To</h3>
            <ul>
              <li class="font-momo"><span class="font-bold font-serif">Name:</span> {{ order?.customer?.name }}</li>
              <li class="font-momo"><span class="font-bold font-serif">Phone:</span> {{ order?.customer?.phone }}</li>
              <li class="font-momo"><span class="font-bold font-serif">Email:</span> {{ order?.customer?.email }}</li>
            </ul>
          </div>
          <div>
            <h3>{{ order?.order_id }}</h3>
            <ul>
              <li class="font-momo"><span class="font-bold font-serif">Order Date: </span> {{ order?.order_date }}</li>
              <li class="font-momo"><span class="font-bold font-serif">Order Status:</span> {{ order?.order_status }}</li>
              <li class="font-momo"><span class="font-bold font-serif">Payment Status:</span> {{ order?.payment_status }}</li>
            </ul>
          </div>
        </div>

        <!-- Invoice Description starts -->
        <table class="table w-full border py-10">
          <thead>
            <tr class="border border-border font-serif">
              <th class="py-1">Product Name</th>
              <th class="py-1">Price</th>
              <th class="py-1">size & Qty</th>
              <th class="py-1">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr class="font-momo"
              v-for="(item, index) in order?.order_details"
              :key="`single-details-item-${index}`"
            >
              <td class="py-1 text-center">
                {{ item?.product?.title }}
              </td>
              <td class="py-1 text-center">
                <span class="fw-bold"
                  >${{
                    item?.product?.discount_price ?? item?.product?.price
                  }}</span
                >
              </td>
              <td class="py-1 text-center">
                <span class="fw-bold">
                  {{ item?.quantity }}
                </span>
              </td>
              <td class="py-1 text-center">
                <span class="fw-bold">
                  ${{
                    (item?.product?.discount_price ?? item?.product?.price) *
                    item?.quantity
                  }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="flex lg:justify-end lg:pt-20 pt-10">
          <div class="lg:w-4/12 w-full">
            <div
              v-if="order?.sub_total"
              class="flex w-full justify-between items-center"
            >
              <p><span class="font-bold font-serif">Sub Total:</span></p>
              <p>${{ order?.sub_total }}</p>
            </div>
            <div class="flex w-full justify-between items-center border-b">
              <p><span class="font-bold font-serif">Delevery Charge:</span></p>
              <p>${{ order?.delivery_charge }}</p>
            </div>
            <div class="flex w-full justify-between items-center pt-2">
              <p class="font-semibold font-serif">Grand Total</p>
              <p class="font-semibold font-serif">${{ order?.grand_total }}</p>
            </div>
          </div>
        </div>

        <div class="pt-20">
          <h3 class="text-lg font-semibold font-serif mb-3">Thank You for Your Purchase!</h3>
          <p class="text-xs">
            We appreciate your business and hope you enjoy your new products. If
            you have any questions or need assistance, please don't hesitate to
            contact our customer support team.
          </p>
        </div>
      </div>
    </div>
  </section>
</template>
