<script setup>
import Search from "@/components/Search.vue";
import { inject, ref } from "vue";
import { useAuthStore } from "@/stores/useAuthStore";
import { useCartStore } from "@/stores/useCartStore";
const authStore = useAuthStore();
const cartStore = useCartStore();
const data = inject("data");
const isNav = ref(false);
</script>
<template>
  <nav class="bg-primary text-center py-2 hidden lg:block">
    <container>
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="flex gap-2">
            <a
              href="tel:{{ data?.phone_number }}"
              class="bg-white p-1 rounded-full flex items-center text-sm text-primary group gap-1"
            >
              <Icon
                name="material-symbols:phone-in-talk-outline-sharp"
                class="text-lg pl-1"
              />
              <span
                class="max-w-0 overflow-hidden opacity-0 group-hover:max-w-xs group-hover:opacity-100 duration-300 transition-all whitespace-nowrap"
              >
                {{ data?.phone_number }}
              </span>
            </a>

            <a
              href="mailto:{{ data?.email }}"
              class="bg-white p-1 rounded-full flex items-center text-sm text-primary group gap-1"
            >
              <Icon name="material-symbols:attach-email" class="text-lg pl-1" />
              <span
                class="max-w-0 overflow-hidden opacity-0 group-hover:max-w-xs group-hover:opacity-100 duration-300 transition-all whitespace-nowrap"
              >
                {{ data?.email }}
              </span>
            </a>
          </div>
        </div>

        <div class="flex items-center gap-1.5 text-white text-xs font-poppins">
          <Icon name="material-symbols:location-on" />
          Dhaka Bangladesh
        </div>
      </div>
    </container>
  </nav>

  <nav>
    <container>
      <div class="flex items-center justify-between w-full pt-3 lg:pt-0">
        <RouterLink to="/">
          <img class="w-32 lg:w-48 h-auto" src="/logo.png" alt="Logo" />
        </RouterLink>

        <div class="hidden lg:block w-full max-w-xl">
          <Search />
        </div>

        <ul class="flex items-center gap-3">
          <li class="relative group hover:text-secondary">
            <RouterLink to="/cart" class="relative flex items-center">
              <span
                class="bg-primary group-hover:bg-secondary absolute -top-2 -right-2 w-5 h-5 rounded-full flex items-center justify-center text-white group-hover:text-white"
              >
                {{ cartStore.getCartLength }}
              </span>
              <Icon
                name="clarity:shopping-cart-line"
                class="text-3xl text-primary group-hover:text-secondary"
              />
            </RouterLink>
          </li>

          <li>
            <RouterLink
              to="/dashboard"
              v-if="authStore?.user"
              class="flex items-center gap-1 hover:text-secondary"
            >
              <Icon
                name="lucide:user-round"
                class="text-3xl text-primary hover:text-secondary"
              />
              <span class="hidden lg:block font-serif">{{
                authStore?.user?.user?.name
              }}</span>
            </RouterLink>
            <RouterLink to="/login" v-else>
              <Icon
                name="lucide:user-round"
                class="text-3xl text-primary hover:text-secondary"
              />
            </RouterLink>
          </li>
          <li class="md:hidden">
            <button @click="isNav = !isNav">
              <Icon
                name="ic:twotone-menu"
                class="text-3xl text-primary hover:text-secondary"
              />
            </button>
          </li>
        </ul>
      </div>
    </container>
  </nav>

  <nav class="border-y border-border hidden lg:block">
    <container>
      <ul class="flex items-center gap-4">
        <li>
          <RouterLink
            to="/products"
            class="block font-medium hover:text-primary font-serif"
          >
            All Products
          </RouterLink>
        </li>
        <li class="relative group">
          <!-- Main Menu Item -->
          <span
            class="cursor-pointer block py-3 font-medium hover:text-primary font-serif"
          >
            Categories
          </span>

          <!-- Dropdown Menu -->
          <ul
            class="absolute left-0 top-full bg-white shadow-lg w-48 hidden group-hover:block z-50"
          >
            <li
              v-for="category in data?.header_categories"
              :key="category?.slug"
              class="border-b last:border-none"
            >
              <RouterLink
                class="block py-2 px-4 text-base font-serif hover:text-primary hover:bg-[#ebe5e1]"
                :to="{
                  path: '/products',
                  query: { category: category?.slug },
                }"
              >
                {{ category?.name }}
              </RouterLink>
            </li>
          </ul>
        </li>
      </ul>
    </container>
  </nav>

  <div
    class="fixed top-0 bottom-0 w-80 bg-primary z-50 transition-all ease-in-out duration-700"
    :class="{ 'right-0': isNav, '-right-80': !isNav }"
  >
    <button class="p-2" @click="isNav = !isNav">
      <Icon name="material-symbols:close" class="text-white text-3xl" />
    </button>
    <ul class="flex flex-col">
      <li>
        <RouterLink
          to="/products"
          class="text-base font-normal block py-3 px-4 text-white font-serif hover:text-gray-300"
        >
          All Products
        </RouterLink>
      </li>
      <li v-for="category in data?.header_categories">
        <RouterLink
          class="text-base font-normal block py-3 px-4 text-white font-serif hover:text-gray-300"
          :to="{
            path: '/products',
            query: { category: category?.slug },
          }"
          >{{ category?.name }}</RouterLink
        >
      </li>
    </ul>
  </div>
</template>
