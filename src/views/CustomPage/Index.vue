<script setup>
import useAxios from '@/composables/useAxios.js';
import {ref, onMounted} from 'vue';
import {useRoute} from 'vue-router';

const {loading, error, sendRequest} = useAxios();
const route = useRoute();

const page = ref(null);
const getPage = async () => {
  const response = await sendRequest({
    method:'get',
    url:`/frontend/v1/get-custom-page/${route.params.slug}`
  });
  if(response){
    page.value = response.data
  }
}

onMounted(() => {
  window.scrollTo(0,0);
  getPage();
})
</script>
<template>
  <AppLayout>
    <section >

      <container class="flex p-2 lg:p-10">
        <div class="w-full max-w-8/12 mx-auto p-5 bg-white shadow-lg editor_data" v-html="page?.content"></div>
      </container>
    </section>
  </AppLayout>
</template>