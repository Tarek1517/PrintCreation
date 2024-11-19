import { createRouter, createWebHistory } from 'vue-router'
import authMiddleware from '@/middleware/auth.js' 

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
      path: '/order-success',
      name: 'order-success',
      component:()=>import("@/views/Order/Success.vue")
    },
	{
		path: '/order-invoice/:id',
		name:'order-invoice',
		component: () => import("@/views/Order/Invoice.vue")
	},
	{
		path:'/:slug',
		name:'custom-page',
		component: () => import("@/views/CustomPage/Index.vue")
	}
  ],
})

router.beforeEach(authMiddleware)
export default router
