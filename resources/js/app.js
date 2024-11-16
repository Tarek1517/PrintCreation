import "vue-select/dist/vue-select.css";
import '@/assets/css/app.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import AppLayout from '@/components/Layouts/AppLayout.vue';
import  Icon  from '@/components/Icon.vue';
import Button from '@/components/Button.vue';
import Loading from '@/components/Loading.vue';
import Search from '@/components/Search.vue';
import  VSelect  from "vue-select";

import 'vue3-toastify/dist/index.css';
import 'flowbite';
import 'summernote/dist/summernote-lite.css';
import 'summernote/dist/summernote-lite.min.js';

import $ from 'jquery';
window.$ = window.jQuery = $;

  

import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(createPinia())
    .use(router)
    .component('AppLayout', AppLayout)
    .component('Icon', Icon)
    .component('Button', Button)
    .component('Search', Search)
    .component("Select", VSelect)
    .component("Loading", Loading)
    .mount('#app')  
