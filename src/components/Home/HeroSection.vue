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
  <section class="py-5">
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
          class="mySwiper py-5 rounded-2xl overflow-hidden"
      >
        <SwiperSlide v-for="slider in data?.hero_slider">
          <a :href="slider?.url" class="block w-full h-40 lg:h-[550px] rounded-2xl overflow-hidden">
            <img class="w-full h-full" :src="slider?.image_url" alt="">
          </a>
        </SwiperSlide>
      </swiper>
    </container>
  </section>
</template>
