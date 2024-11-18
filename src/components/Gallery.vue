<template>
  <div>
    <Swiper
        :style="{
              '--swiper-navigation-color': '#000',
              '--swiper-pagination-color': '#000',
            }"
        :loop="true"
        :spaceBetween="10"
        :navigation="true"
        :thumbs="{ swiper: thumbsSwiper }"
        :modules="modules"
        class="mySwiper2"
    >
      <SwiperSlide v-if="coverImg">
        <InnerImageZoom class="w-full h-auto" :src="coverImg" zoomType="hover"/>
      </SwiperSlide>
      <SwiperSlide v-if="hoverImg">
        <InnerImageZoom class="w-full h-auto" :src="hoverImg" zoomType="hover"/>
      </SwiperSlide>
      <SwiperSlide v-if="images" v-for="(image, index) in images" :key="index">
        <InnerImageZoom class="w-full h-auto" :src="image?.image_url" zoomType="hover"/>
      </SwiperSlide>
    </Swiper>
    <Swiper
        @swiper="setThumbsSwiper"
        :loop="true"
        :spaceBetween="10"
        :slidesPerView="4"
        :freeMode="true"
        :watchSlidesProgress="true"
        :modules="modules"
        class="mySwiper"
    >
      <SwiperSlide v-if="coverImg">
        <img :src="coverImg">
      </SwiperSlide>
      <SwiperSlide v-if="hoverImg">
        <img :src="hoverImg">
      </SwiperSlide>
      <SwiperSlide v-if="images" v-for="(image, index) in images" :key="index">
        <img :src="image?.image_url">
      </SwiperSlide>
    </Swiper>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import '@websitebeaver/vue-magnifier/styles.css'
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import InnerImageZoom from 'vue-inner-image-zoom';

import { Swiper, SwiperSlide } from 'swiper/vue';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';

const modules  = [FreeMode, Navigation, Thumbs];
const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
};


const props = defineProps({
  images:{
    type:Array,
  },
  coverImg: {
    type:String,
  },
  hoverImg: {
    type:String,
  }
})
</script>