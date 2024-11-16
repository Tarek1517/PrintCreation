<script setup>
    import {ref, onMounted} from 'vue';
    import useAxios from '@/composables/useAxios';
    const {loading, error, sendRequest} = useAxios();
    
    const form = ref({
        name:null,
        phone:null,
        email:null,
    })
    
</script>
<template>
    <AppLayout>
        <div>
            
        </div>
    </AppLayout>
</template>