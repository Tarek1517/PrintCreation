<script setup>
import {useCartStore} from '@/stores/useCartStore.js'
import useAxios from '@/composables/useAxios.js';
import {onMounted, ref, computed} from 'vue';
import { toast } from 'vue3-toastify';
import {useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/useAuthStore.js';
import {inject} from 'vue';

const data = inject('data')
const authStore = useAuthStore();

const router = useRouter();
const {error, loading, sendRequest} = useAxios();
const cartStore = useCartStore();

const areas = ref(null);
const getOrderArea = async() => {
	const response = await sendRequest({
		method:'get',
		url: '/frontend/v1/get-all-shipping-area-list'
	});
	if(response) {
		areas.value = response.data;
	}
}

const courierCompany = ref(null);
const getCompany = async() => {
	const response = await sendRequest({
		method:'get',
		url: '/frontend/v1/courier-company'
	});
	if(response) {
		courierCompany.value = response.data;
	}
}

const selectedCourier = ref(null);

// order
const form = ref({
 	user_id: computed(() => authStore?.user?.user?.id),
  payment_method: 'cod',
  shipping_area_id: null,
  order_type: 'customer',
  delivery_charge: computed(() => selectedCourier?.value?.delivery_charge),
  order_items: computed(() => cartStore?.getCartItems || []),
  sub_total: computed(() => cartStore?.getCartTotalPrice || 0),
  courier_company_id: computed(() => selectedCourier?.id)
});

const onOrderSubmit = async () => {
  const response = await sendRequest({
    url:'/frontend/v1/save-order' ,
    method: 'POST',
    data: form.value,
    headers: {
      authorization: `Bearer ${authStore?.user?.token}`,
    },
  });
  if (response){
    toast.success('Order placed successfully');
    setTimeout(() => {
      router.push('/dashboard');
      cartStore.clearCart();
    }, 1000);
  }
}

// import { StripeCheckout } from '@vue-stripe/vue-stripe';
// const publishableKey = "jfdhuvbheshgvbuiedhyn ze";
// const lineItems = ref([
//   {
//     price: 'some-price-id', 
//     quantity: 1,
//   },
// ]);
// const successURL = 'your-success-url';
// const cancelURL = 'your-cancel-url';
// const checkoutRef = ref(null);
// const submit = () => {
//   checkoutRef.value.redirectToCheckout();
// };

onMounted(() => {
  getOrderArea();
  getCompany();
})
</script>
<template>
  <AppLayout>
    <section>
      <container class="flex flex-wrap py-5">
        <div class="w-full lg:w-1/3">
          <div class="p-3 bg-white">
            <div class="flex flex-wrap">
				<div class="w-full lg:w-1/2 px-2 mb-2">
					<label for="title" class="block mb-1 text-xs">Country</label>
					<input type="text" class="border border-gray-600 rounded-md w-full p-2 focus:outline-none" v-model="form.country">
				</div>
				<div class="w-full lg:w-1/2 px-2 mb-2">
					<label for="title" class="block mb-1 text-xs">City</label>
					<input type="text" class="border border-gray-600 rounded-md w-full p-2 focus:outline-none" v-model="form.city">
				</div>
				<div class="w-full lg:w-1/2 px-2 mb-2">
		
					<label for="title" class="block mb-1 text-xs">Area</label>
					<select class="p-2 w-full rounded-md border border-gray-600" v-model="form.shipping_area_id">
					<option v-for="area in areas" :value="area?.id">{{ area?.name }}</option>
					</select>
				</div>
				<div class="w-full px-2 mb-2">
					<label for="title" class="block mb-1 text-xs">Address</label>
					<textarea class="w-full h-16 rounded-md border border-gray-600 focus:outline-none p-2" v-model="form.address"></textarea>
				</div>
				</div>
			<div class="mt-5">
              <h3>Select Courier</h3>
              <div class=" flex flex-wrap">
                <div class="w-1/2 p-2" v-for="item in courierCompany">
                  <input type="radio" :id="item?.id" class="peer" name="courier" hidden :value="item" v-model="selectedCourier">
                  <label :for="item?.id" class=" border-2 border-slate-200 rounded-md p-2 shadow-md cursor-pointer peer-checked:border-primary relative flex flex-col items-center justify-center">
                      <span class="absolute top-2 right-2 check">
                        <Icon name="ic:baseline-check-circle" class="text-xl" />
                      </span>
                    <img class="w-16 h-auto" :src="item?.logo" alt="">
					<h3>{{item?.company_name}}</h3>
                  </label>
                </div>
              </div>
            </div>
            <div class="mt-5">
              <h3>Select Payment Method</h3>
              <div class=" flex flex-wrap">
                <div class="w-1/2 p-2">
                  <input checked type="radio" id="1" class="peer" name="payment_method" hidden value="code">
                  <label for="1" class=" border-2 border-slate-200 rounded-md p-2 shadow-md cursor-pointer peer-checked:border-primary relative flex items-center justify-center">
                      <span class="absolute top-2 right-2 check">
                        <Icon name="ic:baseline-check-circle" class="text-xl" />
                      </span>
                    <img class="w-28 h-auto" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/800px-Stripe_Logo%2C_revised_2016.svg.png" alt="">
                  </label>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="w-full lg:w-1/3 px-4">
          <div class="bg-white">
            <div v-for="item in cartStore?.getCartItems" class="flex flex-col lg:flex-row lg:gap-4 border-b border-gray-200">
              <div class="w-full p-3">
                <div class="flex gap-2">
                  <div>
                    <img class="min-w-16 max-w-16 h-auto rounded-lg" :src="item?.product?.cover_image">
                  </div>
                  <div class="w-full">
                    <h2 class="text-sm font-normal p-0 mb-2">{{item?.product?.title}}</h2>
                    <div class="w-full flex items-center justify-between">
                      <p class="text-sm font-normal">Quantity: {{ item?.attachments ? item?.attachments?.length : item?.selectSku?.selectQty }}</p>
                      <p class="text-sm font-normal">Price: {{ data?.currency_symbol }}{{ item?.selectSku?.price }}</p>
                      <p class="text-sm font-normal">Total: {{ data?.currency_symbol }}{{ item?.selectSku?.price *( item?.attachments ? item?.attachments?.length : item?.selectSku?.selectQty) }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full lg:w-1/3">
          <div class="bg-white">
            <ul>
              <li class="flex items-center justify-between text-sm text-gray-500 px-4 py-2">
                <p>Sub Total </p>
                <p class="text-xl">{{ data?.currency_symbol }}{{ cartStore?.getCartTotalPrice }}</p>
              </li>
              <li class="flex items-center justify-between text-sm text-gray-500 px-4 py-2">
                <p>Delivery Charge</p>
                <p v-if="selectedCourier">{{data?.currency_symbol}}{{ selectedCourier?.delivery_charge }}</p>
                <p v-else>Select Courier Company</p>
              </li>
              <li class="flex items-center justify-between text-sm font-semibold border-t border-gray-300 px-4 py-2">
                <p>Grant Total</p>
                <p v-if="selectedCourier">{{data?.currency_symbol}}{{ cartStore?.getCartTotalPrice + selectedCourier?.delivery_charge}}</p>
              </li>
            </ul>
            <div class="py-2 px-4">
				  <!-- <div>
					<stripe-checkout
					ref="checkoutRef"
					mode="payment"
					:pk="publishableKey"
					:line-items="lineItems"
					:success-url="successURL"
					:cancel-url="cancelURL"
					@loading="v => loading = v"
					/>
					<button @click="submit">Pay now!</button>
				</div> -->
              <button @click="onOrderSubmit" class="block w-full bg-black rounded-full py-2 text-white text-center">Payment & Place Order</button>
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
input[type="radio"]:checked + label .check{
  opacity: 1;
}
</style>