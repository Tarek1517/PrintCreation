<template>
  <Bar
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
  />
</template>

<script setup>
import { ref, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// Define the props
const props = defineProps({
  values: {
    type: Array,
    default: () => []
  }
});

// Initialize chartData with default values
const chartData = ref({
  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
  datasets: [{
    data: [20,10,30,60,20,30,50,40,40,30,20,10],
    backgroundColor: [
      'rgba(255, 99, 132)',  // January
      'rgba(54, 162, 235)',  // February
      'rgba(255, 206, 86)',  // March
      'rgba(75, 192, 192)',  // April
      'rgba(153, 102, 255)', // May
      'rgba(255, 159, 64)',  // June
      'rgba(255, 99, 132)',  // July
      'rgba(54, 162, 235)',  // August
      'rgba(255, 206, 86)',  // September
      'rgba(75, 192, 192)',  // October
      'rgba(153, 102, 255)', // November
      'rgba(255, 159, 64)'   // December
    ]
  }]
});
const chartOptions = {
  responsive: true
};
</script>
