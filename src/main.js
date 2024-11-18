import './assets/main.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import Container from '@/Components/Container.vue'
import 'vue3-toastify/dist/index.css';
import Icon from '@/components/Icon.vue';
import {createDataProvider} from "@/plugins/dataProvider.js";
import { StripePlugin } from '@vue-stripe/vue-stripe';

const options = {
  pk: import.meta.env.STRIPE_PUBLISHABLE_KEY,
  stripeAccount: import.meta.env.STRIPE_ACCOUNT,
  apiVersion: import.meta.env.API_VERSION,
  locale: import.meta.env.LOCALE,
};

const dataProvider = createDataProvider();

const app = createApp(App)

app.use(createPinia())
    .use(router)
    .component('container', Container)
    .component('Icon', Icon)
    .provide('data', dataProvider.data)
	// .use(StripePlugin, options)
    .mount('#app')
