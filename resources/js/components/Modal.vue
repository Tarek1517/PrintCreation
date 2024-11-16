<script setup>
    import { defineProps, defineEmits, ref } from "vue";
    const props = defineProps({
        isOpen: Boolean,
        title:String,
    });
    const emit = defineEmits(["modal-close"]);
</script>
<template>
    <div v-if="isOpen" class="fixed top-0 left-0 bottom-0 right-0 bg-black bg-opacity-60 w-full h-screen flex items-center justify-center">
        <div class="w-full max-w-xl min-h-28 bg-primary  p-4 shadow-lg z-[99999]">
            <div class="flex items-center justify-between">
                <h3 class="font-medium text-lg">{{ title }}</h3>
                <button class="" @click.stop="emit('modal-close')">
                    <Icon name="material-symbols:close" class="text-common text-3xl" />
                </button>
            </div>
            <div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>