import './assets/main.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import Container from '@/Components/Container.vue'
import 'vue3-toastify/dist/index.css';
import Icon from '@/components/Icon.vue';
import {createDataProvider} from "@/plugins/dataProvider.js";

const dataProvider = createDataProvider();

const app = createApp(App)
app.use(createPinia())
    .use(router)
    .component('container', Container)
    .component('Icon', Icon)
    .provide('data', dataProvider.data)
    .mount('#app')
