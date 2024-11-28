<script setup>
import 'swiper/css';
import 'swiper/css/pagination';
import { inject } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Pagination,Autoplay } from 'swiper/modules';
const modules = [Pagination,Autoplay];

const data = inject('data');
</script>
<template>
  <section class="pt-5 pb-5 xl:pt-10">
    <container>
      <swiper
          :spaceBetween="10"
          :centeredSlides="true"
          :autoplay="{
              delay: 2500,
              disableOnInteraction: false,
            }"
                  :pagination="{
                  dynamicBullets: true,
            }"
          :modules="modules"
          class="mySwiper py-10 overflow-hidden rounded-xl"
      >
        <SwiperSlide v-for="slider in data?.hero_slider">
          <a :href="slider?.url" class="block w-full h-48 lg:h-[400px] object-fit:cover overflow-hidden ">
            <img class="w-full h-full" :src="slider?.image_url" alt="">
          </a>
        </SwiperSlide>
      </swiper>
    </container>
  </section>
</template>
