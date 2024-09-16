<script setup>
import { computed } from 'vue';

const emits = defineEmits(['update:modelValue']);
const props = defineProps({
	modelValue: Boolean,
	disabled: {
		type: Boolean,
		default: false,
	},
});

const toggle = () => {
	if (!props.disabled) emits('update:modelValue', !props.modelValue);
};

const color = computed(() => {
	let opacity = props.disabled ? 'opacity-50' : 'opacity-100'
	return props.modelValue ? `bg-blue-500 ${opacity}` : `bg-gray-400 ${opacity} ring-gray-300`
});
</script>

<template>
	<div
		@click="toggle"
		class="px-5 py-1 ring-1 ring-offset-transparent ring-offset-1 rounded-full relative h-6"
		:class="[color, !disabled ? 'cursor-pointer' : 'cursor-not-allowed']"
	>
		<div
			class="transition-transform duration-150 easy-in-out transform bg-white w-5 h-5 rounded-full absolute top-0.5"
			:class="modelValue ? '-translate-x-1/10' : '-translate-x-9/10'"
		></div>
	</div>
</template>
