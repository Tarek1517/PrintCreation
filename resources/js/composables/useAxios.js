import { ref } from 'vue';
import axios from 'axios';
import { useAdminStore } from '@/stores/useAdminStore.js';
import { toast } from 'vue3-toastify';
import { useRouter } from 'vue-router';

const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    withCredentials: true,
    xsrfHeaderName: "X-XSRF-TOKEN",
});

export default function useAxios() {
    const loading = ref(false);
    const error = ref(null);
    const adminStore = useAdminStore();
    const router = useRouter();

    const sendRequest = async (config) => {
        loading.value = true;
        error.value = null;

        const { method = 'GET' } = config;
        config.method = method.toUpperCase();

        const token = adminStore.getToken();
        if (token) {
            axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }   

        try {
            const response = await axiosInstance(config);
            return response;
        } catch (err) {
            error.value = err.response ? err.response.data : err.message;
            toast.error(error.value.message || 'An error occurred', { autoClose: 2000, theme: 'dark' });
            throw err;
        } finally {
            loading.value = false;
        }
    };

    return {
        loading,
        error,
        sendRequest,
    };
}
