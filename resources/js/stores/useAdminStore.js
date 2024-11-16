import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export const useAdminStore = defineStore('admin', () => {
    const router = useRouter();
    const admin = ref(JSON.parse(localStorage.getItem('admin')) ?? null);  // Store admin data
    const isLoggedIn = computed(() => !!admin.value);  // Check if admin is logged in
    const loading = ref(false);
    const error = ref(null);

    async function fetchAdmin() {
        const storedAdmin = JSON.parse(await getLocalStorage());

        if (storedAdmin) {
            try {
                loading.value = true;
                const { data } = await axios.get('/api/admin/me', {
                    headers: {
                        "Authorization": `Bearer ${storedAdmin?.token}`
                    }
                });

                if (data) {
                    admin.value = data;
                } else {
                    await clearLocalStorage();
                }
            } catch (err) {
                await clearLocalStorage();
                error.value = err.response?.data || "An error occurred";
            } finally {
                loading.value = false;
            }
        } else {
            await clearLocalStorage();
        }
    }

    // Admin Login Function
    async function login(credential) {
        try {
            loading.value = true;
            // CSRF protection for login (if needed)
            await axios.get("/sanctum/csrf-cookie");    

            const loginResponse = await axios.post("/api/admin/login", credential);

            if (loginResponse.data) {
                await setLocalStorage(loginResponse.data);
                admin.value = loginResponse.data;
                return loginResponse;
            }
        } catch (err) {
            error.value = err.response?.data || "Login failed";
            throw err;
        } finally {
            loading.value = false;
        }
    }

    // Admin Signup Function (if needed)
    async function signup(signupData) {
        try {
            loading.value = true;
            const signupResponse = await axios.post("/api/admin/create", signupData);

            if (signupResponse.data?.data) {
                await setLocalStorage(signupResponse.data.data);
                admin.value = signupResponse.data.data;
                return signupResponse;
            }
        } catch (err) {
            error.value = err.response?.data || "Signup failed";
            throw err;
        } finally {
            loading.value = false;
        }
    }

    // Admin Logout Function
    async function logout() {
        try {
            loading.value = true;
            await axios.post("/api/admin/logout");
            admin.value = null;
            await clearLocalStorage();
            router.push({ name: "Home" });
        } catch (err) {
            error.value = err.response?.data || "Logout failed";
        } finally {
            loading.value = false;
        }
    }
    async function setLocalStorage(admin) {
        localStorage.setItem('admin', JSON.stringify(admin));
    }

    async function clearLocalStorage() {
        localStorage.removeItem('admin');
    }

    async function getLocalStorage() {
        return localStorage.getItem('admin');
    }

    function getToken() {
        return JSON.parse(localStorage.getItem("admin"))?.token;
    }
    return { admin, login, signup, isLoggedIn, fetchAdmin, logout, loading, error, getToken }
});
