<script setup>
import { inject } from "vue";

const data = inject("data");
</script>
<template>
  <footer class="bg-gray-800 mt-10">
    <container>
      <div class="flex flex-wrap py-10">
        <div class="w-1/2 lg:w-1/4 pr-5">
          <RouterLink to="/">
            <img class="w-32 lg:w-48 h-auto" src="/logo.png" alt="Logo" />
          </RouterLink>
          <p class="text-gray-400 font-mono font-thin text-sm">
            Lorem Ipsum is simply dummy <br />
            text of the printing .
          </p>
          <p class="text-gray-400 font-serif font-thin text-sm">
            {{ data?.phone_number }}
          </p>
          <p class="text-gray-400 font-serif font-thin text-sm">
            {{ data?.email }}
          </p>
        </div>

        <div
          class="w-1/2 lg:w-1/4 mt-5 lg:mb-10"
          v-for="column in data?.footer_columns"
        >
          <div>
            <h3 class="text-2xl text-white mb-3 font-serif">
              {{ column?.title }}
            </h3>
            <ul class="flex flex-col gap-2 font-serif font-light">
              <li v-for="page in column?.pages || []" :key="page?.slug">
                <RouterLink
                  v-if="page?.slug && page?.title"
                  :to="`/${page.slug}`"
                  class="text-sm text-gray-400 hover:text-primary"
                >
                  {{ page.title }}
                </RouterLink>
              </li>
              <li class="text-gray-400 font-thin">
                <div v-html="column?.content"></div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </container>
    <container>
      <div
        class="flex flex-col lg:flex-row items-center justify-center lg:justify-between pb-5 text-sm font-thin font-serif"
      >
        <p class="text-gray-400 text-center">
          Copyright © 2024 Sign & Print Creation. All Rights Reserved.
        </p>
        <p class="text-gray-400 text-center">
          <a href="">Web Development Company</a> Creative Tech Park
        </p>
      </div>
    </container>
  </footer>
</template>
