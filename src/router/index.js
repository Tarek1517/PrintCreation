import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('@/views/Index.vue'),
    },
	{
		path: '/login',
		name: 'login',
		component: () => import ('@/views/Auth/Login.vue')
	},
	{
		path: '/register',
		name: 'register',
		component: () => import('@/views/Auth/Register.vue')
	},
	{
		path: '/dashboard',
		name:'dashboard',
		component: () => import('@/views/Customer/Dashboard.vue')
	},
    {
      path: '/products',
      name: 'products',
      component: () => import('@/views/Product/Index.vue'),
    },
    {
      path: '/product/:slug',
      name: 'productDetail',
      component: () => import('@/views/Product/Show.vue'),
    },
 	{
      path: '/cart',
      name: 'cart',
      component:()=>import("@/views/Customer/Cart.vue")
    },
    {
      path: '/checkout',
      name: 'checkout',
      component:()=>import("@/views/Order/Checkout.vue")
    },
	{
		path:'/:slug',
		name:'CustomPage',
		component: () => import("@/views/CustomPage/Index.vue")
	}
  ],
})

export default router
