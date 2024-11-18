<script setup>
import useAxios from '@/composables/useAxios.js';
import Gallery from '@/components/Gallery.vue'
import {useCartStore} from "@/stores/useCartStore.js";
import { inject } from 'vue';
import {ref, onMounted, watch} from 'vue';
import {useRoute} from 'vue-router';
import { toast } from 'vue3-toastify';

const cartStore = useCartStore();
const {error, loading, sendRequest} = useAxios();
const route = useRoute();
const data = inject('data');


const selectVarient = ref([]);
const buyQty = ref(1);
const varientPrice = ref(0);
const selectVarientProduct = ref({});
const product = ref(null);

const getProduct = async () => {
  const response = await sendRequest({
    url: `/frontend/v1/product/${route.params.slug}`,
  });
  if(response.data){
    product.value = response.data;
    selectVarient.value = response.data.attributes;
  }
}
watch(
    [selectVarient, buyQty],
    ([item, qty]) => {
      if (Array.isArray(item) && qty) {
        varientPrice.value = 10 * qty;

        const title = item.map((i) => i.selectVariant).join('/') + '/';
        const selectedVarient = product?.value?.stocks?.find(
            (stockItem) => stockItem.varient === title
        );

        selectVarientProduct.value = {
          ...selectedVarient,
          totalPrice: selectedVarient?.price * qty,
        };
      } else {
        console.error('Invalid item or quantity:', item, qty);
      }
    },
    { deep: true }
);


// Attachments Array
const attachments = ref([
  { text: "", image: null }, // Initial Attachment
]);

// Add More Attachment Field
const addAttachment = () => {
  attachments.value.push({ text: "", image: null });
};

// Remove Attachment Field
const removeAttachment = (index) => {
  attachments.value.splice(index, 1);
};

// Handle Image Upload
const handleImageUpload = (event, index) => {
  const file = event.target.files[0];
  if (file) {
    attachments.value[index].image = file;
  }
};

// Add to Cart
const addToCart = () => {
  if (product.attachment === 1) {
    // Validate Attachments
    const isValid = attachments.value.every(
      (attachment) =>
        (product.attachment_type === "text" || product.attachment_type === "both"
          ? attachment.text.trim()
          : true) &&
        (product.attachment_type === "image" || product.attachment_type === "both"
          ? attachment.image
          : true)
    );

    if (!isValid) {
      alert("Please complete all attachment fields before adding to the cart.");
      return;
    }
  }

  const cartItem = {
    product: {
      id: product.value.id,
      shop_id: product.value.shop_id,
      title: product.value.title,
      cover_image: product.value.cover_image_url,
      price: product.value.discount_price ? product.value.discount_price : product.value.price,
    },
    selectSku: isNaN(selectVarientProduct?.totalPrice)
      ? {
          sku: product.value.sku,
          price:  product.value.discount_price ? product.value.discount_price : product.value.price,
          selectQty: buyQty,
        }
      : {
          id: selectVarientProduct.id,
          sku: selectVarientProduct.sku,
          varient: selectVarientProduct.varient,
          price: selectVarientProduct.price,
          selectQty: buyQty,
        },
    attachments: attachments.value, 
  };

  cartStore.addToCart(cartItem);
};
onMounted(()=> {
  getProduct();
});
</script>
<template>
  <AppLayout>
    <section class="py-12">
		<container>
			   <div class="flex flex-col lg:flex-row">
        <div class="w-full lg:w-[30%]">
          <div class="bg-white h-full p-4">
            <Gallery :coverImg="product?.cover_image_url" :hoverImg="product?.hover_image" :images="product?.images" />
          </div>
        </div>
        <div class="w-full lg:w-[50%] px-4">
          <div class=" bg-white p-4">
            <h3 class=" font-base text-md lg:text-2xl">{{ product?.title }}</h3>
            <p class="my-4 rounded inline-block bg-primary px-2 py-0.5 text-white text-sm font-medium">{{product?.category?.name}}</p>
            <p class="text-xl lg:text-2xl flex items-center gap-2"><strike class="text-rose-700">{{ data?.currency_symbol }} {{product?.price}}</strike> {{ data?.currency_symbol }}{{product?.discount_price}}</p>
			
				<div
					v-for="(attribute, i) in product?.attributes"
					:key="attribute.id">
					<h2 class="text-base font-normal mb-2">
						{{ attribute?.option?.name }}
					</h2>
					<div class="flex flex-wrap gap-2">
						<div
							class="mb-2"
							v-for="(tag, index) in attribute?.tags"
							:key="index">
							<input
								type="radio"
								class="hidden peer"
								:id="`${i}-varient-${index}`"
								v-model="attribute.selectVariant"
								:name="attribute?.option?.name"
								:value="tag" />
							<label
								:for="`${i}-varient-${index}`"
								class="cursor-pointer w-full border rounded-md px-2.5 py-1.5 peer-checked:bg-secondary peer-checked:text-primary flex flex-col justify-between peer-checked:border-primary">
								<p
									class="text-center text-sm font-normal">
									{{ tag }}
								</p>
							</label>
						</div>
					</div>
				</div>
            <div v-if="product?.key_features?.length > 0" class="border-y border-gray-300 py-4">
              <ul class="flex flex-col gap-3">
                <li v-for="item in product?.key_features">{{ item?.name }}</li>
              </ul>
            </div>
            <div class="py-4">
              <h2>About this item</h2>
				<div v-html="product?.short_description"></div>
            </div>
          </div>
        </div>
        <div class="w-full lg:w-[20%]">
          <div class="border border-gray-300 p-5 bg-white">
            <p class="text-xl">৳{{ product?.discount_price ? product?.discount_price : product?.price}}</p>

			<div>
				<!-- Attachment Section -->
				<div v-if="product?.attachment === 1">
				<h3>Attachment</h3>

				<!-- Dynamic Attachment Fields -->
				<div v-for="(attachment, index) in attachments" :key="index" class="mb-4">
					<!-- Text Attachment -->
					<textarea
					v-if="product?.attachment_type === 'text' || product?.attachment_type === 'both'"
					v-model="attachment.text"
					placeholder="Add your text here"
					class="w-full h-20 border border-gray-600 rounded-md mb-2 p-2"
					></textarea>

					<!-- Image Attachment -->
					<label
					v-if="product?.attachment_type === 'image' || product?.attachment_type === 'both'"
					:for="`attachment-image-${index}`"
					class="cursor-pointer flex items-center justify-center p-3 rounded-md border border-dashed border-primary"
					>
					<span class="text-primary">Upload Image</span>
					<input
						:id="`attachment-image-${index}`"
						type="file"
						class="hidden"
						@change="handleImageUpload($event, index)"
					/>
					</label>

					<!-- Remove Attachment Button -->
					<button
					v-if="attachments.length > 1"
					type="button"
					class="text-red-600 mt-2"
					@click="removeAttachment(index)"
					>
					Remove
					</button>
				</div>

				<!-- Add More Button -->
				<button
					type="button"
					class="bg-blue-500 text-white px-4 py-2 rounded-md"
					@click="addAttachment"
				>
					Add More
				</button>
			</div>
			</div>
        
            <h3 class="text-green-500 text-base font-medium py-3">Stock In</h3>
            <button @click="addToCart"  class="text-sm text-center bg-primary text-white rounded-full hover:bg-gray-600 w-full block py-1.5 my-2"> Add to Cart </button>
          </div>
        </div>
      </div>
	</container>
    </section>

    <section>
		<container>
			<h2>Products related to this item</h2>
			<div class="grid grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-3">
				<ProductCard :data="item" v-for="item in product?.relatedProducts" />
			</div>
		</container>
    </section>
  </AppLayout>
</template>
