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
        <SwiperSlide >
          <InnerImageZoom class="w-full h-auto  " :src="coverImg" zoomType="hover"/>
        </SwiperSlide>
        <SwiperSlide v-for="slide in images">
          <InnerImageZoom class="w-full h-auto  " :src="slide?.url" zoomType="hover"/>
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
        <SwiperSlide>
          <img :src="coverImg">
        </SwiperSlide>
        <SwiperSlide v-for="slide in images">
          <img :src="slide?.url">
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
  
  
  
  
  
  
  defineProps({
    images:{
      type:Array,
      required:true
    },
    coverImg:String,
  })
  </script>