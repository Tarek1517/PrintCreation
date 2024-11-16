import { useAdminStore } from '@/stores/useAdminStore.js';

export default (to, from, next) => {
    const auth = useAdminStore();
    const publicPages = ['Login', 'Home']; // Define routes that don't need authentication
    const authRequired = !publicPages.includes(to.name); // Check if the route requires authentication

    // If authentication is required and the admin is not logged in, redirect to the login page
    if (authRequired && !auth.isLoggedIn) {
        return next({ name: 'Login' });
    }

    // If already logged in and trying to access the login page, redirect to dashboard or another route
    if (to.name === 'Login' && auth.isLoggedIn) {
        return next({ name: 'Dashboard' });
    }

    next(); // Proceed to the next route if no conditions are met
};
