<script setup>
import useAxios from "@/composables/useAxios.js";
import Gallery from "@/components/Gallery.vue";
import { useCartStore } from "@/stores/useCartStore.js";
import { inject } from "vue";
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";
import ProductCard from "@/components/ProductCard.vue";

const cartStore = useCartStore();
const { error, loading, sendRequest } = useAxios();
const route = useRoute();
const data = inject("data");

const selectVarient = ref([]);
const buyQty = ref(1);
const varientPrice = ref(0);
const selectVarientProduct = ref({});
const product = ref(null);

const getProduct = async () => {
  const response = await sendRequest({
    url: `/frontend/v1/product/${route.params.slug}`,
  });
  if (response.data) {
    product.value = response.data;
    selectVarient.value = response.data.attributes;
  }
};
watch(
  [selectVarient, buyQty],
  ([item, qty]) => {
    if (Array.isArray(item) && qty) {
      varientPrice.value = 10 * qty;

      const title = item.map((i) => i.selectVariant).join("/") + "/";
      const selectedVarient = product?.value?.stocks?.find(
        (stockItem) => stockItem.varient === title
      );

      selectVarientProduct.value = {
        ...selectedVarient,
        totalPrice: selectedVarient?.price * qty,
      };
    } else {
      console.error("Invalid item or quantity:", item, qty);
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
        (product.attachment_type === "text" ||
        product.attachment_type === "both"
          ? attachment.text.trim()
          : true) &&
        (product.attachment_type === "image" ||
        product.attachment_type === "both"
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
      product_info: product.value.product_info,
      specification: product.value.specification,
      cover_image: product.value.cover_image_url,
      price: product.value.discount_price
        ? product.value.discount_price
        : product.value.price,
    },
    selectSku: isNaN(selectVarientProduct?.totalPrice)
      ? {
          sku: product.value.sku,
          price: product.value.discount_price
            ? product.value.discount_price
            : product.value.price,
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
onMounted(() => {
  getProduct();
});
</script>
<template>
  <AppLayout>
    <section class="py-5 lg:py-12">
      <container>
        <div class="flex flex-col lg:flex-row gap-6 mx-auto">
          <div class="w-full lg:w-[40%]">
            <div class="bg-white h-full">
              <Gallery
                :coverImg="product?.cover_image_url"
                :hoverImg="product?.hover_image"
                :images="product?.images"
              />
            </div>
          </div>
          <div class="w-full lg:w-[60%] lg:px-4">
            <div class="bg-white lg:pl-4">
              <h3 class="font-base text-md lg:text-xl font-medium font-serif">
                {{ product?.title }}
              </h3>
              <p
                class="my-4 rounded inline-block bg-secondary px-2 py-0.5 text-white text-sm font-medium font-serif"
              >
                {{ product?.category?.name }}
              </p>
              <p
                class="text-xl lg:text-xl flex items-center text-slate-950 font-semibold"
              >
                <strike class="text-gray-400 text-sm font-serif px-1"
                  ><span class="text-sm">$</span>{{ data?.currency_symbol }}
                  {{ product?.price }}</strike
                >
                <span class="text-2xl">$</span>{{ data?.currency_symbol
                }}{{ product?.discount_price }}
              </p>

              <div
                v-for="(attribute, i) in product?.attributes"
                :key="attribute.id"
              >
                <h2 class="text-base font-normal mb-2">
                  {{ attribute?.option?.name }}
                </h2>
                <div class="flex flex-wrap gap-2">
                  <div
                    class="mb-2"
                    v-for="(tag, index) in attribute?.tags"
                    :key="index"
                  >
                    <input
                      type="radio"
                      class="hidden peer"
                      :id="`${i}-varient-${index}`"
                      v-model="attribute.selectVariant"
                      :name="attribute?.option?.name"
                      :value="tag"
                    />
                    <label
                      :for="`${i}-varient-${index}`"
                      class="cursor-pointer w-full border rounded-md px-2.5 py-1.5 peer-checked:bg-secondary peer-checked:text-primary flex flex-col justify-between peer-checked:border-primary"
                    >
                      <p class="text-center text-sm font-normal font-serif">
                        {{ tag }}
                      </p>
                    </label>
                  </div>
                </div>
              </div>
              <div
                v-if="product?.key_features?.length > 0"
                class="border-y border-border py-2 mt-4"
              >
                <ul class="flex flex-col gap-3">
                  <li v-for="item in product?.key_features">
                    {{ item?.name }}
                  </li>
                </ul>
              </div>
              <div class="py-4 text-gray-700">
                <div v-html="product?.product_info"></div>
              </div>

              <button
                @click="addToCart"
                class="text-base text-center bg-primary text-white px-10 py-2 rounded-md hover:bg-secondary block font-serif "
              >
                Add to Cart
              </button>
            </div>
            <div class="bg-white pt-3 lg:p-4">
              <div>
                <!-- Attachment Section -->
                <div v-if="product?.attachment === 1">
                  <h3 class="pb-2 text-poppins text-dark">Attachments</h3>

                  <!-- Dynamic Attachment Fields -->
                  <div
                    v-for="(attachment, index) in attachments"
                    :key="index"
                    class="mb-4"
                  >
                    <!-- Text Attachment -->
                    <textarea
                      v-if="
                        product?.attachment_type === 'text' ||
                        product?.attachment_type === 'both'
                      "
                      v-model="attachment.text"
                      placeholder="Add your text here"
                      class="w-full h-20 border border-gray-600 rounded-md mb-2 p-2"
                    ></textarea>

                    <!-- Image Attachment -->
                    <label
                      v-if="
                        product?.attachment_type === 'image' ||
                        product?.attachment_type === 'both'
                      "
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
                    <div class="flex justify-end mt-2">
                      <button
                        v-if="attachments.length > 1"
                        type="button"
                        class="flex items-center text-red-600 bg-red-600 rounded-md px-2 py-1 mt-2"
                        @click="removeAttachment(index)"
                      >
                        <Icon
                          icon="material-symbols:delete-forever-outline"
                          class="text-white text-xl"
                        />
                      </button>
                    </div>
                  </div>

                  <!-- Add More Button -->
                  <button
                    type="button"
                    class="bg-secondary text-white px-2 py-1 rounded-md hover:bg-primary"
                    @click="addAttachment"
                  >
                    <Icon
                      icon="material-symbols:add"
                      class="text-white text-xl"
                    />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </container>
    </section>

    <section>
      <container class="py-5 lg:py-12">
        <h2
          class="flex flex-col lg:flex-row gap-4 mx-auto font-base text-2xl font-semibold mb-5"
        >
          <span class="border-b-4 border-primary font-serif">Product specifications </span>
        </h2>
        <div class="flex flex-col lg:flex-row gap-4 mx-auto">
          <div v-html="product?.specification"></div>
        </div>
      </container>
    </section>

    <section>
      <container class="lg:pt-20 pt-8 pb-11 mb-11">
        <h2
          class="flex flex-col lg:flex-row gap-4 mx-auto font-base text-2xl font-semibold mb-5"
        >
          <span class="border-b-4 border-primary font-serif"
            >Products related to this item</span
          >
        </h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8 mx-auto">
          <ProductCard
            :data="item"
            class="custom-height"
            v-for="item in product?.relatedProducts"
            :key="item.id"
          />
        </div>
      </container>
    </section>
  </AppLayout>
</template>

<style>
/* Add custom height override for this section */
.custom-height img {
  height: 11rem; /* Example height: 10rem (40px) */
}
</style>
