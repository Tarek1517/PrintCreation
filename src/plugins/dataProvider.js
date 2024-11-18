import { ref } from 'vue';
import useAxios from '@/composables/useAxios.js';

export function createDataProvider() {
    const data = ref(null);
    const { sendRequest } = useAxios();

    const getData = async () => {
        const response = await sendRequest({
            method: 'get',
            url: '/print-creation',
        });
        if (response) {
            data.value = response.data;
        }
    };
    getData();
    return {
        data
    };
}