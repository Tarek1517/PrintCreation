<script setup>
import { useCartStore } from "@/stores/useCartStore.js";
import { inject } from "vue";
const data = inject("data");
const cartStore = useCartStore();
</script>
<template>
  <section>
    <container>
      <div
        class="relative bg-cover bg-center h-44 w-full mt-5 lg:mt-10 mb-11 rounded-lg overflow-hidden"
        style="background-image: url('/public/slider-2.png')"
      >
        <div
          class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center text-center"
        >
          <h1 class="text-center text-xl lg:text-2xl font-semibold py-10">
            <span class="border-b-4 border-primary">Cart Products</span>
          </h1>
        </div>
      </div>
    </container>
  </section>
  <section>
    <container>
      <div class="flex flex-col lg:flex-row lg:gap-8">
        <div class="w-full lg:w-4/5 border border-border rounded mb-5 lg:mb-11">
          <div
            v-if="cartStore && cartStore.getCartItems.length > 0"
            class="bg-white my-5"
          >
            <div
              v-for="item in cartStore?.getCartItems"
              class="relative flex flex-col lg:flex-row gap-5 p-5 mb-5 justify-center items-center lg:items-start"
            >
              <!-- Close Button -->
              <button
                class="text-sm rounded lg:my-11 bottom-1 top-0 right-0 lg:top-auto lg:right-auto"
                @click="cartStore.removeFromCart(item)"
              >
                <Icon
                  icon="gridicons:cross-circle"
                  class="text-gray-600 text-xl hover:text-rose-600"
                />
              </button>

              <!-- Image Section: Centered in Row on Desktop, Centered in Column on Mobile -->
              <div
                class="w-full lg:max-w-[150px] lg:w-auto flex justify-center mb-4 lg:mb-0"
              >
                <img
                  class="w-3/5 h-auto rounded"
                  :src="item?.product?.cover_image"
                />
              </div>

              <!-- Product Details Section -->
              <div
                class="w-full order-last lg:order-none lg:w-3/5 text-center lg:text-left"
              >
                <h3 class="font-medium text-lg font-serif">
                  {{ item?.product?.title }}
                </h3>

                <h3 class="text-sm font-medium font-mono">
                  Attachment ({{ item?.attachments?.length }})
                </h3>
                <h3 class="text-sm font-medium font-mono">
                  Quantity:
                  {{
                    item?.attachments
                      ? item?.attachments?.length
                      : item?.selectSku?.selectQty
                  }}
                </h3>

                <div
                  class="flex flex-wrap gap-2 py-2 font-mono justify-center lg:justify-start"
                >
                  <div v-for="attachment in item?.attachments">
                    <p v-if="attachment?.image">Image: Added</p>
                    <p>Text: {{ attachment?.text }}</p>
                  </div>
                </div>
              </div>

              <!-- Price Section -->
              <div class="w-full lg:w-2/5 text-center lg:text-right">
                <p
                  class="text-xl text-primary font-semibold font-serif lg:my-8"
                >
                  <span class="text-xl">$</span> {{ data?.currency_symbol
                  }}{{ item?.product?.price }}
                </p>
              </div>
            </div>
          </div>
          <div v-else class="flex items-center justify-center h-40">
            <h3 class="font-semibold font-serif">No product has been added</h3>
          </div>
        </div>
        <div class="w-full lg:w-2/5">
          <div class="bg-white p-5 border border-border rounded">
            <table class="border-collapse w-full mb-5">
              <thead>
                <tr>
                  <th class="text-left">
                    <span class="border-b-2 border-primary">Product Name</span>
                  </th>
                  <th class="text-left">
                    <span class="border-b-2 border-primary">Price</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in cartStore?.getCartItems" :key="item.id">
                  <td class="text-left">
                    <h3 class="font-medium text-xs font-serif pt-1">
                      {{ item?.product?.title }}
                    </h3>
                  </td>
                  <td class="text-left p-2">
                    <p class="text-lg font-serif">
                      <span class="text-xl">$</span> {{ data?.currency_symbol
                      }}{{ item?.product?.price }}
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>

            <p class="text-lg font-normal font-serif">
              SubTotal ({{ cartStore?.getCartLength }} Item):
              <span class="font-bold">{{ cartStore?.getCartTotalPrice }}</span>
            </p>
            <RouterLink
              to="/checkout"
              class="text-sm text-center bg-primary text-white hover:bg-secondary px-10 rounded-md w-full block py-1.5 my-3"
            >
              Proceed to checkout
            </RouterLink>
          </div>
        </div>
      </div>
    </container>
  </section>
</template>
