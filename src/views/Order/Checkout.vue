<script setup>
import { useCartStore } from "@/stores/useCartStore.js";
import useAxios from "@/composables/useAxios.js";
import { onMounted, ref, computed } from "vue";
import { toast } from "vue3-toastify";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/useAuthStore.js";
import { inject } from "vue";

const data = inject("data");
const authStore = useAuthStore();

const router = useRouter();
const { error, loading, sendRequest } = useAxios();
const cartStore = useCartStore();

const areas = ref(null);
const getOrderArea = async () => {
  const response = await sendRequest({
    method: "get",
    url: "/frontend/v1/get-all-shipping-area-list",
  });
  if (response) {
    areas.value = response.data;
  }
};

const courierCompany = ref(null);
const getCompany = async () => {
  const response = await sendRequest({
    method: "get",
    url: "/frontend/v1/courier-company",
  });
  if (response) {
    courierCompany.value = response.data;
  }
};
const selectedCourier = ref(null);

// order
const form = ref({
  user_id: computed(() => authStore?.user?.user?.id),
  payment_method: "stripe",
  shipping_area_id: null,
  order_type: "customer",
  delivery_charge: computed(() => selectedCourier?.value?.delivery_charge),
  order_items: computed(() => cartStore?.getCartItems || []),
  sub_total: computed(() => cartStore?.getCartTotalPrice || 0),
  courier_company_id: computed(() => selectedCourier?.id),
});

const paymentAndPlaceOrder = async () => {
  try {
    const response = await sendRequest({
      method: "post",
      url: "/frontend/v1/save-order",
      data: form.value,
      headers: {
        authorization: `Bearer ${authStore?.user?.token}`,
      },
    });
    if (response?.data) {
      cartStore.clearCart();
      window.location.href = response.data.url;
    } else {
      console.error("Stripe session URL not found in response:", response);
    }
  } catch (error) {
    console.error("Error initiating payment:", error);
  }
};

onMounted(() => {
  const query = new URLSearchParams(window.location.search);
  if (query.get("success")) {
    toast.success("Order Placed");
  }
  if (query.get("canceled")) {
    toast.info("Payment Canceled");
  }
  getOrderArea();
  getCompany();
});
</script>
<template>
  <AppLayout>
    <section>
      <container>
        <div
          class="relative bg-cover bg-center h-44 w-full mt-5 lg:mt-10 mb-5 lg:mb-11 rounded-lg overflow-hidden"
          style="background-image: url('/public/slider-2.png')"
        >
          <div
            class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center text-center"
          >
            <h1 class="text-center text-xl lg:text-2xl font-semibold py-10">
              <span class="border-b-4 border-primary">Checkout</span>
            </h1>
          </div>
        </div>
      </container>
    </section>
    <section>
      <container>
        <div class="flex flex-col lg:flex-row gap-8">
          <div class="w-full lg:w-2/3 lg:p-5 border border-border rounded">
            <div class="p-3 bg-white">
              <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 px-2 mb-2">
                  <label for="title" class="block mb-1 text-xs font-mono"
                    >Country</label
                  >
                  <input
                    type="text"
                    class="border border-gray-600 rounded-md w-full p-2 focus:outline-none focus:border-primary"
                    v-model="form.country"
                  />
                </div>

                <div class="w-full lg:w-1/2 px-2 mb-2">
                  <label for="title" class="block mb-1 text-xs font-mono"
                    >City</label
                  >
                  <input
                    type="text"
                    class="border border-gray-600 rounded-md w-full p-2 focus:outline-none focus:border-primary"
                    v-model="form.city"
                  />
                </div>
                <div class="w-full lg:w-1/2 px-2 mb-2">
                  <label for="title" class="block mb-1 text-xs font-mono"
                    >Area</label
                  >
                  <select
                    class="p-2 w-full rounded-md border border-gray-600 focus:border-primary"
                    v-model="form.shipping_area_id"
                  >
                    <option v-for="area in areas" :value="area?.id">
                      {{ area?.name }}
                    </option>
                  </select>
                </div>
                <div class="w-full px-2 mb-2">
                  <label for="title" class="block mb-1 text-xs font-mono"
                    >Address</label
                  >
                  <textarea
                    class="w-full h-16 rounded-md border border-gray-600 focus:outline-none p-2 focus:border-primary"
                    v-model="form.address"
                  ></textarea>
                </div>
              </div>
              <div class="mt-5">
                <h3 class="font-serif pl-2">Select Courier</h3>
                <div class="flex flex-wrap">
                  <div class="lg:w-1/2 p-2" v-for="item in courierCompany">
                    <input
                      type="radio"
                      :id="item?.id"
                      class="peer"
                      name="courier"
                      hidden
                      :value="item"
                      v-model="selectedCourier"
                    />
                    <label
                      :for="item?.id"
                      class="border-2 border-slate-200 rounded-md p-2 shadow-md cursor-pointer peer-checked:border-primary relative flex flex-col items-center justify-center focus:border-primary"
                    >
                      <span class="absolute top-2 right-2 check">
                        <Icon name="ic:baseline-check-circle" class="text-xl" />
                      </span>
                      <img class="w-16 h-auto" :src="item?.logo" alt="" />
                      <h3>{{ item?.company_name }}</h3>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mt-5">
                <h3 class="font-serif pl-2">Select Payment Method</h3>
                <div class="flex flex-wrap">
                  <div class="w-1/2 p-2">
                    <input
                      checked
                      type="radio"
                      id="1"
                      class="peer"
                      name="payment_method"
                      hidden
                      value="code"
                    />
                    <label
                      for="1"
                      class="border-2 border-slate-200 rounded-md p-2 shadow-md cursor-pointer peer-checked:border-primary relative flex items-center justify-center"
                    >
                      <span class="absolute top-2 right-2 check">
                        <Icon name="ic:baseline-check-circle" class="text-xl" />
                      </span>
                      <img
                        class="w-28 h-auto"
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/800px-Stripe_Logo%2C_revised_2016.svg.png"
                        alt=""
                      />
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="w-full lg:w-1/3 lg:p-5 border border-border rounded">
            <div class="bg-white">
              <ul>
                <li
                  class="flex items-center justify-between text-sm text-gray-500 px-4 py-2"
                >
                  <p class="font-momo">Sub Total</p>
                  <p class="text-lg font-serif font-semibold text-slate-950">
                    <span class="text-xl">$</span> {{ data?.currency_symbol
                    }}{{ cartStore?.getCartTotalPrice }}
                  </p>
                </li>
                <li
                  class="flex items-center justify-between text-sm text-gray-500 px-4 py-2"
                >
                  <p class="font-momo">Delivery Charge</p>
                  <p v-if="selectedCourier">
                    {{ data?.currency_symbol
                    }}{{ selectedCourier?.delivery_charge }}
                  </p>
                  <p v-else class="font-serif">Select Courier Company</p>
                </li>
                <li
                  class="flex items-center justify-between text-sm font-semibold border-t border-border px-4 py-2"
                >
                  <p class="font-serif">Grant Total</p>
                  <p v-if="selectedCourier">
                    {{ data?.currency_symbol
                    }}{{
                      cartStore?.getCartTotalPrice +
                      selectedCourier?.delivery_charge
                    }}
                  </p>
                </li>
              </ul>
              <div class="py-2 px-4">
                <button
                  @click="paymentAndPlaceOrder"
                  class="text-sm text-center bg-primary text-white hover:bg-secondary px-10 rounded-md w-full block py-1.5 my-3"
                >
                  Payment & Place Order
                </button>
              </div>
            </div>
          </div>
        </div>
      </container>
    </section>
  </AppLayout>
</template>

<style scoped>
.check {
  opacity: 0;
}
input[type="radio"]:checked + label .check {
  opacity: 1;
}
</style>
