<script setup>
    import BarChart from '@/components/Chart/BarChart.vue';
    import TopProducts from '@/components/TopProducts.vue';
    import RecentOrder from '@/components/RecentOrder.vue';
    import AppLayout from "@/components/Layouts/AppLayout.vue";
    import {useAdminStore} from "@/stores/useAdminStore.js";
    const adminStore = useAdminStore();
    import useAxios from "@/composables/useAxios.js";
    import { ref, onMounted } from 'vue';
    const {error, loading, sendRequest} = useAxios();
    const data = ref(null);
    const saleData = ref(null);

    const getData = async()=> {
      const response = await sendRequest({
        method:'get',
        url:'/v1/dashboard',
      });

      if(response) {
        data.value = response?.data?.data;
        saleData.value = response?.data?.saleData;
      }
    }


    onMounted(() => {
      getData();
    })

</script>
<template>
  <Loading :value="loading" />

    <AppLayout>

      <div class="flex flex-wrap -mx-1">
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
             border border-common
              shadow
            w-full bg-cover bg-no-repeat bg-center rounded"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-common  flex items-center justify-center">
                  <Icon name="hugeicons:money-receive-circle"  class=" text-xl" />
                </div>
                <h3 class="text-end text-xl font-medium">{{data?.totalSale}}</h3>
              </div>
              <div>
                <p class="text-base text-end">Total Earning</p>
                <p class="text-end font-light text-sm">Compared Last Year</p>
              </div>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                shadow
               bg-primary
                  w-full  border border-gray-600 rounded"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl  border border-gray-100 flex items-center justify-center">
                  <Icon name="ic:sharp-attach-money" class="text-gray-100 text-xl" />
                </div>
                <h3 class="text-end text-xl font-medium   ">{{data?.totalSaleToday}}</h3>
              </div>
              <p class="text-base text-end">Sale Today</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
              
                shadow
                bg-primary
                  w-full  border border-gray-600 rounded"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl  border border-gray-100 flex items-center justify-center">
                  <Icon name="ic:outline-shopping-cart-checkout" class="text-gray-100 text-xl" />
                </div>
                <h3 class="text-end text-xl font-medium   ">{{data?.totalOrder}}</h3>
              </div>
              <div>
                <p class="   text-base text-end">New Order</p>
                <p class="text-end font-light text-sm   ">Compared Last Week</p>
              </div>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                
                shadow
               bg-primary
                  w-full  border border-gray-600 rounded"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-2xl  border border-gray-100 flex items-center justify-center">
                  <Icon name="tabler:shopping-cart-up" class="text-gray-100 text-2xl" />
                </div>
                <h3 class="text-end text-xl font-medium   ">{{data?.pendingOrder}}</h3>
              </div>
              <p class="   text-base text-end">Pending Order</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
        
                shadow
                bg-primary
                  w-full  border border-gray-600 rounded"
          >
            <div class="relative z-10 flex flex-col justify-between h-full">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl  border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:shopping-basket-check-out-03" class="text-gray-100 text-xl" />
                </div>
                <h3 class="text-end text-xl font-medium   ">{{data?.totalProducts}}</h3>
              </div>
              <p class="   text-base text-end">Total Products</p>
            </div>
          </div>
        </div>
        <div class="w-3/5 p-1">
          <div class="bg-primary h-full p-3  border border-gray-600 rounded">
            <h3 class="   text-sm font-normal">Welcome</h3>
            <div class="flex items-center py-2 gap-2">
              <img class="w-8 h-8 rounded-full" src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?uid=R102446229&ga=GA1.1.1386564851.1716744340&semt=sph" alt="">
              <div>
                <h3 class="   font-medium text-sm">{{adminStore?.admin?.admin?.name}}</h3>
                <p class="text-xs font-normal   ">Admin</p>
              </div>
            </div>
            <div class="flex items-center">
              <p class="text-xs font-normal    w-1/2">Have a nice day! Did you know that you can quickly add your favorite product or category?</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                bg-primary
                shadow
                  w-full  border border-gray-600 rounded"
          >
            <div class="relative z-10 flex flex-col justify-between h-full gap-4">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:shopping-basket-check-out-03" class="text-gray-100 text-xl" />
                </div>
                <h3 class="text-end text-xl font-medium   ">{{data?.totalCustomer}}</h3>
              </div>
              <p class="   text-base text-end">Total Customer</p>
            </div>
          </div>
        </div>
        <div class="w-1/5 p-1">
          <div
              class="
              h-full
              p-4
                
                shadow
                bg-primary
                  w-full  border border-gray-600 rounded"
          >
            <div class="relative z-10 flex flex-col justify-between gap-4 h-full">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-slate-400/50 border border-gray-100 flex items-center justify-center">
                  <Icon name="hugeicons:shopping-basket-check-out-03" class="text-gray-100 text-xl" />
                </div>
                <h3 class="text-end text-xl font-medium   ">{{data?.cancelOrder}}</h3>
              </div>
              <p class="   text-base text-end">Total Cancel Orders</p>
            </div>
          </div>
        </div>
      </div>  

      <div class="flex mt-4 " >
          <div class="w-2/3 pr-2">
              <div class="p-4 shadow bg-primary border border-slate-600 ">
                  <BarChart />
              </div>
          </div>
          <div class="w-1/3 pl-2">
              <div class="shadow bg-white">
                  <TopProducts :data="data?.topProducts" />
              </div>
          </div>
      </div>

    <div class="mt-5 bg-white">
        <RecentOrder :data="data?.recentOrder" />
    </div>
    </AppLayout>
</template>
