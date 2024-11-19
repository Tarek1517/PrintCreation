<script setup>
import {ref} from 'vue';
import {useAdminStore} from "@/stores/useAdminStore.js";
const adminStore = useAdminStore();
const props = defineProps({
        text: {
            type: Boolean,
            default: true
        }
    });

    const isDashboardLinks = ref(false);
    const isProductsLinks = ref(false);
    const isCmsLinks = ref(false);
    const isOrderLinks = ref(false);
    const isUserLinks = ref(false);
</script>

<template>
    <div class="relative">
      <div>
        <img src="http://printcreation.ctpse.info/images/logo.png" class="w-40 h-auto mx-auto">
      </div>
      <ul class="flex flex-col gap-5 pl-5 pb-40">
            <!-- Dashboard  -->
            <li>
                <RouterLink to="/dashboard" class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isDashboardLinks = !isDashboardLinks">
                    <Icon name="hugeicons:dashboard-square-setting"  class="text-lg text-cyan-500" />
                    <span class="text-sm font-normal transition-all ease-in-out duration-300">Dashboard</span>
                </RouterLink>
            </li>

            <!-- Dashboard End -->
            



            <!-- Products  -->
            <li>
                <div class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isProductsLinks = !isProductsLinks">
                    <Icon   name="hugeicons:archive-02" class="text-lg text-red-500" />
                    <span class=" text-sm font-normal transition-all ease-in-out duration-300">Products</span>
                    <div class="absolute top-1/2 -translate-y-1/2 right-2 transition-all  ease-in-out duration-300" :class="{'rotate-90 ' : isProductsLinks}">
                    <Icon name="ic:twotone-keyboard-arrow-right" size="20" class="  transition-all ease-in-out duration-300"  />
                    </div>
                </div>
                <div class="overflow-hidden">
                    <ul class="shop-links flex flex-col gap-4 pl-4 py-4" :class="{'shop-links--active' : isProductsLinks}">
                        <li>
                            <RouterLink to="/products" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Products</span>
                            </RouterLink>
                        </li>
                        <li>
                            <RouterLink to="/category" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Category</span>
                            </RouterLink>
                        </li>

                        <li>
                            <RouterLink to="/product/variations" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Variations</span>
                            </RouterLink>
                        </li>
                        <li>
                            <RouterLink to="/stock" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Stock</span>
                            </RouterLink>
                        </li>
                        
<!--                        <li>-->
<!--                            <RouterLink to="/product-review" class="flex items-center">-->
<!--                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />-->
<!--                                <span class="text-sm  ">Review</span>-->
<!--                            </RouterLink>-->
<!--                        </li>-->
                    </ul>
                </div>
            </li>
            <!-- Products End -->

            <!-- Order  -->
            <li>
                <RouterLink to="/order" class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isOrderLinks = !isOrderLinks">
                      <Icon   name="hugeicons:shopping-bag-02" class="text-lg text-pink-500" />
                    <span class="  text-sm font-normal transition-all ease-in-out duration-300">Order</span>
                </RouterLink>
            </li>
        <li>
          <RouterLink to="/shipping" class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isOrderLinks = !isOrderLinks">
            <Icon   name="hugeicons:shopping-bag-02" class="text-lg text-pink-500" />
            <span class="  text-sm font-normal transition-all ease-in-out duration-300">Shipping</span>
          </RouterLink>
        </li>
		<li>
          <RouterLink to="/courier-company" class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isOrderLinks = !isOrderLinks">
            <Icon   name="hugeicons:shopping-bag-02" class="text-lg text-pink-500" />
            <span class="  text-sm font-normal transition-all ease-in-out duration-300">Courier Company</span>
          </RouterLink>
        </li>
            <!-- Order End -->

            <!-- Users  -->
            <li>
                <RouterLink to="/customers" class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isUserLinks = !isUserLinks">
                      <Icon   name="hugeicons:user" class="text-lg text-amber-400" />
                      <span class="  text-sm font-normal transition-all ease-in-out duration-300">Customers</span>
                </RouterLink>
            </li>
            <!-- Users End -->

            <!-- CMS  -->
            <li>
                <div class="group flex items-center gap-3  rounded-lg transition-all ease-in-out duration-300 cursor-pointer relative" @click="isCmsLinks = !isCmsLinks">
                      <Icon   name="system-uicons:window-content" class="text-xl text-violet-500" />
                    <span class="  text-sm font-normal transition-all ease-in-out duration-300">CMS</span>
                    <div class="absolute top-1/2 -translate-y-1/2 right-2 transition-all  ease-in-out duration-300" :class="{'rotate-90 ' : isCmsLinks}">
                    <Icon name="ic:twotone-keyboard-arrow-right" size="20" class="  transition-all ease-in-out duration-300"  />
                    </div>
                </div>
                <div class="overflow-hidden">
                    <ul class="shop-links flex flex-col gap-4 pl-4 py-4" :class="{'shop-links--active' : isCmsLinks}">
                        <li>
                            <RouterLink to="/slider" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Home Slider</span>
                            </RouterLink>
                        </li>
                        <li>
                            <RouterLink to="/home-sections" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Home Sections</span>
                            </RouterLink>
                        </li>
                        <!-- <li>
                            <RouterLink to="/advertise" class="flex items-center gap-3 ">
                                <Icon name="material-symbols-light:circles-outline" class=" " />
                                <span class="text-sm  ">Advertise</span>
                            </RouterLink>
                        </li> -->
                        <li>
                            <RouterLink to="/custom-pages" class="flex items-center">
                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />
                                <span class="text-sm  ">Pages</span>
                            </RouterLink>
                        </li>
<!--                        <li>-->
<!--                            <RouterLink to="/blog" class="flex items-center">-->
<!--                              <Icon name="ph:dot-outline-bold" class="text-xl text-common" />-->
<!--                                <span class="text-sm  ">Blog</span>-->
<!--                            </RouterLink>-->
<!--                        </li>-->
                    </ul>
                </div>
            </li>
            <!-- CMS End -->

            <!-- Setting -->
            <li>
                <RouterLink to="/setting" class="flex items-center gap-3 ">
                      <Icon name="hugeicons:settings-02" class="text-lg text-lime-500" />
                    <span class="text-sm  ">Setting</span>
                </RouterLink>
            </li>
            <!-- Setting End--> 
        </ul>
    </div>
</template>
