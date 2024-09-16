<template>
	<Chart type="doughnut" :data="productsData" :options="productsOptions" :canvasProps="{ height: props.height }" />
	<div class="my-4">
		<div v-for="(prod, index) in productsData.labels" class="flex items-center justify-between py-3 border-b">
			<p class="flex items-center justify-between gap-3">
				<span class="relative inline-flex rounded h-8 w-8 bg-red-500 shadow-lg" :style="{ background: productsData.datasets[0].backgroundColor[index] }"></span>
				<span>{{ prod }}</span>
			</p>
			<span>{{ productsData.datasets[0].data[index] }} uds</span>
		</div>
	</div>
</template>

<script setup>
import Chart from 'primevue/chart';
import { ref } from 'vue';

const props = defineProps({
	height: {
		type: Number,
		default: 200
	}
})
const productsData = ref({
	labels: ['Longaniza fresca', 'Longaniza Seca', 'Morcilla', 'Vino tinto', 'Chuletón Ayrshire'],
	datasets: [
		{
			label: 'Products',
			backgroundColor: ['#3cacf1', '#fcc048', '#a471ff', '#fc6c8c', '#b8a4e8'],
			borderWidth: 2,
			hoverOffset: 10,
			borderColor: '#ffffff66',
			data: Array.from({ length: 5 }).map(() => parseInt(Math.floor(Math.random() * 51 + 50))),
		},
	],
});
const productsOptions = ref({
	responsive: true,
	maintainAspectRatio: false,
	indexAxis: 'y',
	plugins: {
		title: {
			display: true,
			text: 'Top five products',
			color: '#9ca3af',
			align: 'start',
		},
		legend: {
			position: 'right',
			align: 'end',
		},
		tooltip: {
			mode: 'index',
			intersect: true,
		},
	},
});
</script>
