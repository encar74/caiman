<script setup>
import { useCurrency } from '@/Composables/currency.js';
import Chart from 'primevue/chart';
import { computed } from 'vue';

const { euro } = useCurrency();

const props = defineProps({
	title: String,
	labels: Array,
	height: {
		type: Number,
		default: 200
	},
	datasets: {
		type: Array,
		default: [],
	},
});

const data = computed(() => ({
	labels: props.labels,
	datasets: props.datasets.map((dataset) => {
		return {
			label: dataset.name,
			data: dataset.data,
			type: dataset.type,
			tension: 0.25,
			borderColor: `${dataset.color}33`,
			backgroundColor: `${dataset.color}99`,
			borderWidth: 5,
			borderRadius: 10,
			borderDash: dataset.dash ? [5, 3] : [],
		};
	}),
}));

const options = {
	responsive: true,
	maintainAspectRatio: false,
	plugins: {
		title: {
			display: true,
			text: props.title,
			color: '#9ca3af',
			align: 'start',
		},
		tooltip: {
			callbacks: {
				label: (ctx) => {
					let label = ctx.label || '';
					if (label) label += ': ';
					if (ctx.parsed.y !== null) label += euro(ctx.parsed.y);
					return label;
				},
				footer: (items) => `Total: ${euro(items.reduce((carry, item) => (carry += item.raw), 0))}`,
			},
		},
	},
	scales: {
		x: {
			grid: {
				display: false,
			},
		},
		y: {
			display: false,
			grid: {
				display: false,
			},
			suggestedMin: 0,
			suggestedMax: 2500,
		},
	},
	interaction: {
		intersect: false,
		mode: 'index',
	},
};
</script>

<template>
	<Chart type="bar" :data="data" :options="options" :canvasProps="{ height: props.height }" />
</template>
