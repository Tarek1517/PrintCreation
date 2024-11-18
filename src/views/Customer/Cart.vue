<script setup>
import { useCartStore } from '@/stores/useCartStore.js';
import { inject } from 'vue';
const data = inject('data');
const cartStore = useCartStore();
</script>
<template>
    <section>
		<container>
		<div class="flex flex-col lg:flex-row gap-5">
			<div class="w-full lg:w-4/5">
			<div class="bg-white my-5">
				<h3 class="text-md lg:text-2xl font-semibold p-5">Shopping Cart</h3>
				<div v-for="item in cartStore?.getCartItems" class="relative border border-gray-500 flex flex-col lg:flex-row gap-3 p-5 mb-5">
				<button class="bg-primary px-5 py-1 text-sm rounded my-2 absolute right-2 bottom-1" @click="cartStore.removeFromCart(item)">Delete</button>				
<div>
					<img class="w-28 h-auto" :src="item?.product?.cover_image">
				</div>
				<div class="w-full order-last lg:order-none lg:w-3/5">
					<h3 class="font-medium text-2xl">{{ item?.product?.title }}</h3>
					
					<!-- <div class="flex flex-col lg:flex-row gap-5 lg:items-center">
					<div
						class="w-20 lg:w-32 h-8 lg:h-10 border border-gray-400 flex items-center">
						<button
							@click="
													cartStore.decrementQty(
														item?.selectSku?.id
													)
												"
							class="text-black w-8 lg:w-10 h-8 lg:h-10 flex items-center justify-center">
						<Icon name="ic:baseline-minus" />
						</button>
						<input
							type="text"
							class="w-8 lg:w-10 h-8 lg:h-10 border border-gray-400 text-center"
							:value="item.selectSku?.selectQty"
							readonly />
						<button
							@click="
													cartStore.incrementQty(
														item?.selectSku?.id
													)
												"
							class="text-black w-8 lg:w-10 h-8 lg:h-10 flex items-center justify-center">
						<Icon name="material-symbols:add" />
						</button>
					</div>
					<button @click="cartStore.removeFromCart(item)" class="border-l border-gray-300 text-sm text-cyan-700 hover:underline px-5 h-5">Delete</button>
					</div> -->
	`				
					<h3 class="text-xl mb-2 font-medium">Attachment ({{item?.attachments?.length}}) </h3>
					<div class="flex flex-wrap gap-2 py-2">		
						<div class="border border-gray-400 py-2 px-6" v-for="attachment in item?.attachments">
							<p v-if="attachment?.image">Image: Added</p>
							<p>Text: {{attachment?.text}}</p>
						</div>
					</div>
				</div>
				<div class="w-full lg:w-1/5">
					<p class="text-xl font-medium lg:text-right">{{data?.currency_symbol}}{{ item?.product?.price }}</p>
				</div>
				</div>
			</div>
			</div>
			<div class="w-full lg:w-1/5">
			<div class="bg-white my-5 p-5">
				<p class="text-lg font-normal">SubTotal ({{ cartStore?.getCartLength }} Item): <span class="font-medium">{{ cartStore?.getCartTotalPrice }}</span></p>
				<RouterLink to="/checkout" class="text-sm text-center bg-yellow-500 rounded-xl hover:bg-yellow-400 w-full block py-1.5 my-2"> Proceed to checkout </RouterLink>
			</div>
			</div>
		</div>
		</container>
    </section>
</template>
