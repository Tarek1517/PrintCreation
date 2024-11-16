
<script setup>


    const props = defineProps({
        links: {
            type: Array
        },
        from: {
            type: Number,
            default: 0
        },
        to: {
            type: Number,
            default: 0
        },
        total: {
            type: Number,
            default: 0
        },
        notShowNumber:{
            type:Boolean,
            default:false,
        }
    });
</script>

<template>
    <div class="flex items-center justify-between p-4">
        <div class="w-1/2">
            <div class="text-gray-300" v-if="!props.notShowNumber">
                Showing <span class="primary-color">{{ from }}</span> to <span class="primary-color">{{ to }}</span> of <span class="primary-color">{{ total }}</span> entries
            </div>
        </div>
        <div class="w-1/2">
            <ul class="w-full flex items-center gap-1 justify-end">
                <li v-for="link in links">
                    <button @click="" class="w-8 h-8 rounded-full flex items-center justify-center border text-gray-500" v-html="link?.label" :class="{'bg-primary text-white' : link?.active}"></button>
                </li>
            </ul>
        </div>
    </div>
</template>

