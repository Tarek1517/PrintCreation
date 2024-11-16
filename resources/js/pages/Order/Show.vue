<script setup>

    import useAxios from '@/composables/useAxios';
    import { useRoute } from 'vue-router';
    import {ref, onMounted, watch} from 'vue';
    import { toast } from 'vue3-toastify';

    
    const {loading, error, sendRequest} = useAxios();
    const route = useRoute();


    const order = ref(null);
    const isMounted = ref(false);

    const getOrder = async() => {
        const response = await sendRequest({
            method:'get',
            url:`/v1/order/${route.params.id}`,
        });

        if(response){
            order.value = response.data;
            statusData.value.order_status = response.data.order_status
            paymentData.value.payment_status = response.data.payment_status
        }
    }

    const statuses = [
        {
            name: 'pending'
        },
        {
            name: 'received'
        },
        {
            name: 'process'
        },
        {
            name: 'shipped'
        },
        {
            name: 'delivered'
        },
        {
            name: 'cancel',
        }
    ]


    const pStatus = [
        {
            name: 'pending'
        },
        {
            name: 'paid'
        },
        {
            name: 'cancelled',
        }
    ]
    
    const statusData= ref({
        order_status:null
    });
    const paymentData = ref({
        payment_status: null
    })

    const updateOrderStatus = async() => {
        if (!isMounted.value) return;
        const response = await sendRequest({
            method:'post',
            url:`/v1/order/${route.params.id}`,
            data: statusData.value,
            params: {
                _method:'PATCH'
            },
        });

        if(response){
            toast.success('Order Status Updated Successfully', {autoClose:500});
        }
    }


    const updatePaymentStatus = async() => {
        if (!isMounted.value) return;
        const response = await sendRequest({
            method:'post',
            url:`/v1/order/${route.params.id}`,
            data: paymentData.value,
            params: {
                _method:'PATCH'
            },
            headers: {
                authorization: `Bearer ${authStore.user.token}`,
            }
        });

        if(response){
            toast.success('Payment Status Updated Successfully', {autoClose:500});
        }
    }

    watch(statusData, updateOrderStatus,  {deep:true});
    watch(paymentData, updatePaymentStatus,  {deep:true});
    

    onMounted(() => {
        getOrder().then(() => {
            isMounted.value = true; 
        });
    })
</script>
<template>
    <Loading :value="loading" />
    <AppLayout>
        <div class="flex items-center justify-between p-4 bg-primary text-gray-300 shadow-md">
            <h3>Order Id: <span class="text-red-600 font-medium">{{ order?.order_id }}</span></h3>
            <div class="flex items-center gap-4">
              <div>
                <RouterLink :to="`/order-invoice/${order?.id}`" class="bg-common text-white text-sm font-normal px-4 py-2 rounded ">Print</RouterLink>
              </div>
                <div>
                    <label for="order-status" class="mb-1 block text-sm">Payment Status</label>
                    <Select
                        v-if="order"
                        label="name"
                        class="w-44"
                        :options="pStatus"
                        :reduce="item => item.name"
                        v-model="paymentData.payment_status"
                    >

                    </Select>
                </div>
                <div>
                    <label for="order-status" class="mb-2 text-sm flex items-center gap-2">
                        Order Status
                    </label>
                    <Select
                        v-if="order"
                        label="name"
                        class="w-44"
                        :options="statuses"
                        :reduce="item => item.name"
                        v-model="statusData.order_status"
                    >

                    </Select>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mt-5">
            <div class="w-4/6">
                <div class=" bg-primary text-gray-300 shadow-md mb-10">
                    <h3 class="text-lg p-3">Order Summery</h3>
                    <table class="w-full text-sm text-left rtl:text-right text-black">
                        <thead class="text-xs text-white uppercase bg-secondary">
                            <tr>
                            <th scope="col" class="px-16 py-3">
                                <span class="sr-only">Image</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Varient
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3 ">
                                Total
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-300">
                            <tr v-for="item in order?.order_details" >
                                <td class="py-1 px-6 flex items-center gap-4">
                                    <img  :src="item?.product?.cover_image" class="w-20 max-w-full max-h-full" alt="Apple Watch">
                                    <h3>{{ item?.product?.title }}</h3>
                                </td>
                                <td class="px-6 py-1 font-semibold text-xs">
                                    {{ item?.stock?.varient }}
                                </td>
                                <td class="px-6 py-1 font-semibold text-xs">
                                    {{ item?.quantity }}
                                </td>
                                <td class="px-6 py-1 font-semibold text-xs">
                                    ৳{{ item?.stock?.price ?? item?.product?.price }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="w-full flex">
                    <div class="w-1/2 lg:pr-2">
                        <div class="p-4 bg-primary mb-5 shadow-md text-gray-300">
                            <h3 class="text-lg mb-3">Shipping Information</h3>
                            <div v-if="order?.address" class="flex flex-col gap-4">
                                <div class="w-full flex items-center justify-between">
                                    <span>Country</span>
                                    <span>{{ order?.address?.country  }}</span>
                                </div>
                                <div class="w-full flex items-center justify-between">
                                    <span>City</span>
                                    <span>{{ order?.address?.city }}</span>
                                </div>
                                <div class="w-full flex items-center justify-between">
                                    <span>Area</span>
                                    <span>{{ order?.address?.area?.name }}</span>
                                </div>
                                <div class="w-full flex items-center justify-between">
                                    <span>Phone</span>
                                    <span>{{ order?.address?.phone }}</span>
                                </div>
                                <div class="w-full flex items-center justify-between">
                                    <span>Email</span>
                                    <span>{{ order?.address?.email }}</span>
                                </div>    
                                <div class="w-full flex items-center justify-between">
                                    <span>Address</span>
                                    <span>{{ order?.address?.address }}</span>
                                </div>
                            </div>
                            <div>
                              <p>Address: {{order?.customer_address}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 lg:pr-2">
                        <div class="p-4 bg-primary mb-5 shadow-md text-gray-300">
                            <h3 class="text-lg mb-3">Customer Information</h3>
                            <div class="flex flex-col gap-4">
                                <div class="w-full flex items-center justify-between">
                                    <span>Name</span>
                                    <span>{{ order?.customer?.name ?? order?.customer_name }}</span>
                                </div>
                                <div class="w-full flex items-center justify-between">
                                    <span>Phone</span>
                                    <span>{{ order?.customer?.phone ?? order?.customer_phone}}  </span>
                                </div>
                                <div class="w-full flex items-center justify-between">
                                    <span>Email</span>
                                    <span>{{ order?.customer?.email ?? 'Guest'}}</span>
                                </div>
                                
                            
                                <div class="w-full flex items-center justify-between">
                                    <span>Joined</span>
                                    <span>{{ order?.customer?.created_at ?? 'Guest'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-2/6 lg:pl-5">
                <div class="p-4 bg-primary text-gray-300 mb-5 shadow-md">
                    <h3 class="text-lg mb-4">Order Summery</h3>
                    <div class="flex flex-col gap-4">
                        <div class="w-full flex items-center justify-between">
                            <span>Order Created</span>
                            <span>{{ order?.order_date }}</span>
                        </div>
                        <div class="w-full flex items-center justify-between">
                            <span>Sub Total</span>
                            <span>{{ order?.sub_total }}</span>
                        </div>
                        <div class="w-full flex items-center justify-between">
                            <span>Delivery Fee</span>
                            <span>৳{{ order?.delivery_charge}}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-primary text-gray-300 shadow-md">
                    <div class="w-full flex items-center justify-between">
                        <span>Total</span>
                        <span>৳{{ order?.grand_total }}</span>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>