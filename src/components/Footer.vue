<script setup>
	import { inject } from 'vue';

const data = inject('data');
</script>
<template>
  <footer class="bg-gray-800">
    <container>
      <div class="flex flex-wrap py-10">
        <div class="w-1/2 lg:w-1/4" v-for="column in data?.footer_columns">
          <div>
            <h3 class="text-2xl text-white mb-3">{{column?.title}}</h3>
            <ul class="flex flex-col gap-2">
              <li v-for="page in column?.pages">
                <RouterLink :to="`/${page?.slug}`" class="text-white text-sm font-normal">{{page?.title}}</RouterLink>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </container>
    <container>
      <div class="flex flex-col lg:flex-row items-center justify-center lg:justify-between pb-5">
        <p class="text-white text-center ">Copyright © 2024 Sign & Print Creation. All Rights Reserved.</p>
        <p class="text-white text-center"><a href="">Web Development Company</a> Creative Tech Park</p>
      </div>
    </container>
  </footer>
</template>