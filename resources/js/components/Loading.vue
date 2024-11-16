<script setup>
  const props = defineProps({
    value: {
      type: Boolean,
      default: false
    }
  })
</script>

<template>
    <div v-if="value" class="spinner-box fixed top-0 left-0 bottom-0 right-0 w-full h-screen flex items-center justify-center z-40 bg-opacity-60 backdrop-blur-sm">
        <div class="pulse-container relative z-50">  
            <div class="pulse-bubble pulse-bubble-1 bg-common"></div>
            <div class="pulse-bubble pulse-bubble-2 bg-common"></div>
            <div class="pulse-bubble pulse-bubble-3 bg-common"></div>
        </div>
    </div>
</template>


<style scoped>
    /* PULSE BUBBLES */

.pulse-container {
  width: 120px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.pulse-bubble {
  width: 20px;
  height: 20px;
  border-radius: 50%;
}

.pulse-bubble-1 {
    animation: pulse .4s ease 0s infinite alternate;
}
.pulse-bubble-2 {
    animation: pulse .4s ease .2s infinite alternate;
}
.pulse-bubble-3 {
    animation: pulse .4s ease .4s infinite alternate;
}



@keyframes pulse {
  from {
    opacity: 1;
    transform: scale(1);
  }
  to {
    opacity: .25;
    transform: scale(.75);
  }
}
</style>