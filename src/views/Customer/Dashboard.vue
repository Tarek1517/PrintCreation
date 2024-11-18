<script setup>
import {useAuthStore} from "@/stores/useAuthStore.js";
import useAxios from '@/composables/useAxios.js';
import {ref, onMounted} from 'vue';
import moment from 'moment';
import Modal from "@/components/Modal.vue";
import { toast } from "vue3-toastify";
import { inject } from 'vue';
const currencySetting = inject('currencySetting');

const {loading, error, sendRequest} = useAxios();
const authStore = useAuthStore();


const tabs = [
  'Order',
  'Profile',
];
const activeTab = ref(0);

const customer = ref(null);
const customerLoading = ref(false);
const getCustomer = async () => {
  customerLoading.value = true
  const response = await sendRequest({
    method:'get',
    url:`/frontend/v1/customer/${authStore?.user?.user?.id}`,
    headers: {
      authorization: `Bearer ${authStore?.user?.token}`,
    },
  });

  if(response) {
    customer.value = response.data
    customerLoading.value = false
  }
}

const orders = ref(null)
const getCustomerOrder = async () => {
  const response = await sendRequest({
    method:'get',
    url:'/frontend/v1/get-customer-order',
	params: {	
	user_id: authStore?.user?.user?.id
},
    headers: {
      authorization: `Bearer ${authStore?.user?.token}`,
    },
  });
  if(response){

    orders.value = response.data
console.log(orders)
  }
}


onMounted(async () => {
  window.scrollTo(0,0);
  await getCustomer();
  await getCustomerOrder();
})
</script>
<template>

    <section  class="w-full h-40 lg:h-60 bg-[url('https://img.freepik.com/premium-vector/3d-vector-set-online-shopping-items-floating-air-mobile-phone-coupons-bag-gift-credit-card-basket_624031-736.jpg?w=1800')] bg-no-repeat bg-cover">
    </section>
    <section class="px-6 lg:px-0 max-w-3xl mx-auto -mt-16 lg:-mt-28 pb-10">
      <div class="p-5 bg-white shadow">
        <div class="flex items-start lg:items-center">
          <div class="w-12 h-12 lg:w-20 lg:h-20 rounded-full overflow-hidden border-4 border-slate-100">
            <img class="w-full h-full object-cover" src="https://cdn-icons-png.freepik.com/256/15232/15232242.png?uid=R102446229&ga=GA1.1.1386564851.1716744340&semt=ais_hybrid">
          </div>
          <div class="pl-5">
            <h3 class="text-xl lg:text-3xl font-semibold">{{authStore?.user?.user?.name}}</h3>
            <p class="mb-2 text-sm">{{moment(customer?.created_at).format('MMMM Do YYYY')}}</p>
            <span class="inline-flex items-center gap-2 border rounded-md px-2 py-1 text-xs">
              <Icon name="mdi:check-decagram" class="text-blue-600 text-lg" />
              verified account
            </span>
          </div>
        </div>
      </div>
      <Container class="pb-10 max-w-xl mt-10">
        <ul class="flex items-center border-b border-gray-300 mb-4 bg-white">
          <li  v-for="(tab, index) in tabs" :key="index">
            <button
                @click="activeTab = index"
                :class="[ 'px-4 py-2  w-full border-b', activeTab === index ? 'border-primary' : 'text-gray-600',
                                    ]"
            >
              {{ tab }}
            </button>

          </li>
          <li>
            <button @click="authStore?.logout" class="text-gray-600 flex items-center gap-2">
              Logout
              <Icon name="solar:logout-broken" />
            </button>
          </li>

        </ul>

        <div v-if="activeTab === 0">
          <div class="flex flex-col gap-4 bg-white">
			
            <div v-if="orders" class="flex gap-3 w-full border border-gray-400 p-3 rounded" v-for="order in orders">
              <div class="min-w-28 max-w-28 h-auto bg-slate-200 rounded-md overflow-hidden">
                <!-- <img v-if="order?.orders[0]?.order_details[0]?.product?.cover_image_url" :src="order?.orders[0]?.order_details[0]?.product?.cover_image_url" class="w-full h-full"> -->
              </div>
              <div class="w-full relative">
                <RouterLink :to="`/order-invoice/${order?.id}`" class="absolute top-0 right-0 block border border-gray-300 px-2 py-1 text-xs rounded">view</RouterLink>
                <div>
                  <h3 class="text-lg">{{order?.order_code}}</h3>
                  <p>Order Date: {{order?.order_date}}</p>
                  <p>Price: {{order?.grand_total}}</p>
                  <span>Status: {{order?.order_status}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="activeTab === 1">

          <div v-if="customerLoading" class="w-full border bg-white border-gray-300 rounded-md p-4 mb-5">
            <h3 class="mb-4 h-6 w-80 bg-slate-300 rounded animate-pulse"></h3>
            <p class="h-5 mb-2 w-40 bg-slate-300 rounded animate-pulse"></p>
            <p class="h-5 w-56 bg-slate-300 rounded animate-pulse"></p>
          </div>
          <div v-else class="border border-gray-300 rounded-lg p-4 mb-5 bg-white">
            <h3 class="text-xl font-semibold mb-2">{{customer?.name}}</h3>
            <div class="flex items-center gap-1 mb-1">
              <Icon name="hugeicons:call" />
              {{customer?.phone}}
            </div>
            <div class="flex items-center gap-1">
              <Icon name="hugeicons:mail-01" />
              {{customer?.email}}
            </div>
          </div>
        </div>
      </Container>
    </section>
</template>