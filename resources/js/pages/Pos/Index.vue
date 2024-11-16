<template>
    <AppLayout>
        <section>
            <div class="flex gap-4">
                <div class="w-4/6"       >
                    <div class="bg-green-200/25 p-4 h-screen">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <Icon name="ic:sharp-compost" class="text-3xl text-primary" />
                                <h3 class="text-primary text-3xl font-semibold">Pos</h3>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 dark:bg-gray-900">
                                <label for="table-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-primary dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-primary rounded-lg w-96 bg-gray-50 focus:ring-primary focus:border-primary" placeholder="Search for Products">
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Select
                                    class="w-28"
                                    placeholder="select category"
                                    :options="['Canada', 'United States']"
                                ></Select>
                                <Select
                                    class="w-28"
                                    placeholder="select Brand"
                                    :options="['Canada', 'United States']"
                                ></Select>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-1/3">
                                <div class="mt-10 bg-white rounded-lg shadow-lg relative overflow-hidden group ">
                                    <span class="absolute flex items-center justify-center z-20 top-0 left-0 right-0 bottom-0 w-full h-full bg-primary
                                                     opacity-0 group-hover:opacity-30 transition-all ease-in-out duration-500" >
                                        <Icon name="material-symbols:add-circle-outline-rounded" class= "relative z-30 text-4xl text-gray-950 font-bold" />
                                    </span>
                                    <div class="relative">
                                        <img class="rounded-t-lg  " src="https://img.freepik.com/free-photo/front-view-beauty-products-shelf-with-copy-space_23-2150718013.jpg?t=st=1719206950~exp=1719210550~hmac=4c007720d6ae2f1992fb78228d18cff691d5601909bd0d0ffca52c639d21ea37&w=740" alt="">
                                        <span class="absolute top-2 right-2 rounded-lg bg-primary px-2 py-1 text-white text-xs">0</span>
                                    </div>
                                    <div class="px-3">
                                        <p class="text-lg font-medium pt-6">Products</p>
                                        <p class="text-sm font-medium pb-4 text-primary">$1200</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-2/6">
                    <div>
                        <div class="flex items-center justify-between p-2">
                            <v-select></v-select>
                           <button>Clear</button>
                        </div>
                        <div class="flex items-center justify-between p-2 shadow">
                            <h3 class="font-medium">Current Order()</h3>
                           <button>Card</button>
                        </div>
                    </div>
                    <div>
                        <div class="p-2 overflow-y-auto pos-products">
                            <!--  Selected Products     -->
                            <div class="bg-gray-50/20 flex gap-3 p-2 rounded w-full mb-2" v-for="item in 10">
                                <div class="w-1/4">
                                    <img v-if="item?.image" :src="item?.image" class="w-full h-20 rounded" alt="">
                                    <div v-else class="bg-gray-300 w-full h-20 rounded flex items-center justify-center">
                                        <p class="text-gray-600 text-xl font-semibold">Service</p>
                                    </div>
                                </div>
                                <div class="relative w-3/4">
                                    <button>clear</button>
                                    <h3 class="text-sm mb-1">{{item?.name}}</h3>
                                    <div class="flex items-center justify-between mt-3">
                                        <div>
                                            <p class="font-light text-sm text-white">Price: <span class="text-primary font-bold">0.00</span></p>
                                            <p class="font-light text-sm text-white">Sub Total: <span class="text-primary font-bold">0.00</span></p>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button>clear</button>
                                            <input type="text" readonly class="w-5 h-6 flex text-center outline-0 border-0 font-normal bg-transparent text-white" :value="item?.buyQty">
                                            <button>clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 shadow">
                        <ul class="flex flex-col gap-2">
                            <li class="flex items-center justify-between">
                                <h3>Sub Total</h3>
                                <h3>500</h3>
                            </li>
                            <li class="flex items-center justify-between">
                                <h3>Tax</h3>
                                <h3>500</h3>
                            </li>
                            <li class="flex items-center justify-between">
                                <h3>Shipping</h3>
                                <h3>500</h3>
                            </li>
                            <li class="flex items-center justify-between border-b border-white">
                                <h3>Discount</h3>
                                <h3>500</h3>
                            </li>

                            <li class="flex items-center justify-between">
                                <h3 class="text-2xl">Total</h3>
                                <h3 class="text-2xl">50,00</h3>
                            </li>
                        </ul>
                        <div class="flex items-end justify-between mt-4 gap-4">
                            <div class="flex items-center gap-3">
                                <div class="relative">
<!--                                    <UFormGroup v-if="isShipping" class="absolute w-30 -top-10 left-0" label="Shipping">-->
<!--                                        <UInput placeholder="000"  />-->
<!--                                    </UFormGroup>-->
                                    <button>clear</button>

                                </div>
                                <div class="relative">
<!--                                    <UFormGroup v-if="isDiscount" class="absolute w-30 -top-10 left-0" label="Discount">-->
<!--                                        <UInput placeholder="000" />-->
<!--                                    </UFormGroup>-->
                                    <Button>clear</Button>
                                </div>
                            </div>
                            <Button>clear</Button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </AppLayout>
</template>
<script setup>

import AppLayout from "@/components/Layouts/AppLayout.vue";
import Button from "@/components/Button.vue";
</script>
