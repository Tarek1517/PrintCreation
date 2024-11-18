<script setup>
import Search from "@/components/Search.vue";
import {inject} from "vue";
import { useAuthStore } from "@/stores/useAuthStore";
import { useCartStore } from "@/stores/useCartStore";
const authStore = useAuthStore();
const cartStore = useCartStore();
const data =  inject('data');
</script>
<template>
  <nav class="bg-primary text-center py-2">
    <p class="text-white">Welcome To Sign & Print Creation</p>
  </nav>

  <nav>
    <container>
      <div class="flex items-center justify-between">
        <RouterLink to="/">
          <img class="w-28 lg:w-40 h-auto" src="http://printcreation.ctpse.info/images/logo.png" alt="Logo">
        </RouterLink>

       <div class="hidden lg:block">
			 <Search />
		</div>

        <ul class="flex items-center gap-3">
          <li>
            <RouterLink to="/cart" class="relative">
			<span class="bg-primary absolute -top-2 -right-2  w-5 h-5 rounded-full flex items-center justify-center text-white">{{cartStore.getCartLength}}</span>
              <Icon name="clarity:shopping-cart-line" class="text-3xl text-primary" />
            </RouterLink>
          </li>
          <li>
			<RouterLink to="/dashboard" v-if="authStore?.user" class="flex items-center gap-1">
              <Icon name="lucide:user-round" class="text-3xl text-primary" />
				<span class="hidden lg:block">{{authStore?.user?.user?.name}}</span>
            </RouterLink>
            <RouterLink to="/login" v-else>
              <Icon name="lucide:user-round" class="text-3xl text-primary" />
            </RouterLink>
          </li>
        </ul>
      </div>
    </container>
  </nav>

  <nav class=" border-y border-gray-300">
    <container>
      <ul class="flex items-center gap-4">
        <li>
          <RouterLink to="/products" class="p-2 block">
            All Products
          </RouterLink>
        </li>
        <li v-for="category in data?.header_categories">
		<RouterLink 
				class="text-base font-normal block py-3"
				:to="{
					path:'/products',
					query: {category:category?.slug}
				}">{{category?.name}}</RouterLink>
		</li>
      </ul>
    </container>
  </nav>
</template>