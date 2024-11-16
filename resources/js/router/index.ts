import { createRouter, createWebHistory } from 'vue-router'
import adminMiddleware from '@/middleware/admin.js';
const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: () => import('@/pages/Index.vue')
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/pages/Auth/Login.vue')
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: () => import('@/pages/Dashboard/Index.vue')
    },
    {
      path:'/analytics',
      name:'analytics',
      component: () => import('@/pages/Dashboard/Analytics.vue')
    },
    {
      path: '/pos',
      name: 'Pos',
      component: () => import('@/pages/Pos/Index.vue')
    },
    {
      path: '/products',
      name: 'Products',
      component: () => import('@/pages/Products/Index.vue')
    },
    {
      path: '/product/variations',
      name: 'ProductVariations',
      component: () => import('@/pages/Products/Variations.vue')
    },
    {
      path: '/create-product',
      name: 'CreateProduct',
      component: () => import('@/pages/Products/Add.vue')
    },
    {
      path: '/edit-product/:slug',
      name: 'EditProduct',
      component: () => import('@/pages/Products/Edit.vue')
    },
    {
      path: '/edit-product-variation/:slug',
      name: 'EditProductVariation',
      component: () => import('@/pages/Products/SetVariation.vue')
    },
    {
      path: '/product-detail/:slug',
      name: 'Detail',
      component: () => import('@/pages/Products/Show.vue')
    },
    {
      path:'/product-review',
      name:'ProductReview',
      component: () => import('@/pages/Products/Review.vue')
    },
    {
      path: '/category',
      name: 'Category',
      component: () => import('@/pages/Category/Index.vue')
    },
    {
      path: '/create-category',
      name: 'CreateCategory',
      component: () => import('@/pages/Category/Add.vue')

    },
    {
      path: '/edit-category/:id',
      name: 'EditCategory',
      component: () => import('@/pages/Category/Edit.vue')

    },
    {
      path: '/category/:id',
      name: 'ShowCategory',
      component: () => import('@/pages/Category/Show.vue')

    },
    {
      path: '/brand',
      name: 'Brand',
      component: () => import('@/pages/Brand/Index.vue')
    },
    {
      path: '/create-brand',
      name: 'CreateBrand',
      component: () => import('@/pages/Brand/Add.vue')
    },
    {
      path: '/edit-brand/:id',
      name: 'EditBrand',
      component: () => import('@/pages/Brand/Edit.vue')
    },
    {
      path: '/stock',
      name: 'Stock',
      component: () => import('@/pages/Stock/Index.vue')
    },
    {
      path: '/customers',
      name: 'Customers',
      component: () => import('@/pages/Customers/Index.vue')
    },
    {
      path: '/create-customer',
      name: 'CreateCustomer',
      component: () => import('@/pages/Customers/Add.vue')
    },
    {
      path: '/edit-customer',
      name: 'EditCstomer',
      component: () => import('@/pages/Customers/Edit.vue')
    },
    {
      path: '/manager',
      name: 'Manager',
      component: () => import('@/pages/Manager/Index.vue')
    },
    {
      path: '/create-manager',
      name: 'CreateManager',
      component: () => import('@/pages/Manager/Add.vue')
    },
    {
      path: '/edit-manager',
      name: 'EditManager',
      component: () => import('@/pages/Manager/Edit.vue')
    },
    {
      path:'/admin',
      name: 'Admin',
      component: () => import('@/pages/Admins/Index.vue'),
    },
    {
      path: '/order',
      name: 'Order',
      component: () => import('@/pages/Order/Index.vue')
    },
    {
      path:'/order/refund-request',
      name: 'RefundRequest',
      component: () => import('@/pages/Order/RefundRequest.vue')
    },
    {
      path:'/order-detail/:id',
      name: 'OrderDetail',
      component: () => import('@/pages/Order/Show.vue')
    },
    {
      path: '/shipping',
      name: 'Shipping',
      component: () => import('@/pages/Shipping/Index.vue')
    },
    {
      path: '/create-shipping',
      name: 'CreateShipping',
      component: () => import('@/pages/Shipping/Add.vue')
    },
    {
      path: '/edit-shipping/:id',
      name: 'EditShipping',
      component: () => import('@/pages/Shipping/Edit.vue')
    },
    {
      path: '/slider',
      name: 'Slider',
      component: () => import('@/pages/Slider/Index.vue')
    },
    {
      path: '/create-slider',
      name: 'CreateSlider',
      component: () => import('@/pages/Slider/Add.vue')
    },
    {
      path: '/edit-slider/:id',
      name: 'EditSlider',
      component: () => import('@/pages/Slider/Edit.vue')
    },
    {
      path: '/advertise',
      name: 'Advertise',
      component: () => import('@/pages/Advertise/Index.vue')
    },
    {
      path: '/create-advertise',
      name: 'CreateAdvertise',
      component: () => import('@/pages/Advertise/Add.vue')
    },
    {
      path: '/edit-advertise',
      name: 'EditAdvertise',
      component: () => import('@/pages/Advertise/Edit.vue')
    },
    {
      path: '/blog',
      name: 'Blog',
      component: () => import('@/pages/Blog/Index.vue')
    },
    {
      path: '/custom-pages',
      name: 'CustomPages',
      component: () => import('@/pages/CustomPages/Index.vue')
    },
    {
      path: '/profile',
      name: 'Profile',
      component: () => import('@/pages/Profile/Index.vue')
    },
    {
      path: '/setting',
      name: 'Setting',
      component: () => import('@/pages/Setting/Index.vue')
    },
    {
      path: '/footer-setting',
      name: 'FooterppSetting',
      component: () => import('@/pages/Setting/FooterSetting.vue')
    },
    {
      path: '/pages',
      name:'Pages',
      component: () => import('@/pages/CustomPages/Index.vue'),
    },
    {
      path: '/create-page',
      name:'CreatePage',
      component: () => import('@/pages/CustomPages/Add.vue'),
    },
    {
      path: '/edit-page/:id',
      name:'EditPage',
      component: () => import('@/pages/CustomPages/Edit.vue'),
    },
    {
      path: '/home-sections',
      name:'HomeSection',
      component: () => import('@/pages/HomeSection/Index.vue'),
    },
    {
      path: '/create-home-sections',
      name:'CreateHomeSection',
      component: () => import('@/pages/HomeSection/Add.vue'),
    },
    {
      path: '/edit-section/:id',
      name: 'EditHomeSection',
      component: () => import('@/pages/HomeSection/Edit.vue')
    },
    {
      path:"/order-invoice/:id",
      name:"OrderInvoice",
      component: () => import("@/pages/Order/Invoice.vue")
    },
    {
      path:'/order-request',
      name:'OrderRequest',
      component: () => import('@/pages/Order/Request.vue')
    }
  ]
})
router.beforeEach(adminMiddleware)
export default router;