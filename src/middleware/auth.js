// @ts-ignore
import { useAuthStore } from '@/stores/useAuthStore.js';

export default (to, from, next) => {
	const auth = useAuthStore()

	let exceptionalRoutes  = ['Login']
	let isGoingExceptionalRoutes  = exceptionalRoutes.includes(to.name)

	let authProtected  = [
        'dashboard',
        'checkout',
        'order-success',
    ]
	let isAuthProtected  = authProtected.includes(to.name)

	if (!auth.isLoggedIn && isAuthProtected) {
		next({ name: 'login', query: { redirect: to.fullPath } })
	} else if (auth.isLoggedIn && isGoingExceptionalRoutes) {
		next({ name: 'dashboard', query: { 'redirect-reason': 'already logged' } })
	} else {
		next()
	}
}