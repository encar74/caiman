<template>
	<input
		ref="input"
		:class="[
			'text-black py-2 border-gray-200 rounded-md outline-0',
			'focus:(border-gray-400 ring-2 ring-sky-500 ring-offset-1)',
			'dark:(border-gray-600 bg-dark-600 text-gray-100 focus:ring-offset-dark-600)',
			{
				'px-4': !withIcon,
				'pl-11 pr-4': withIcon,
			},
		]"
		:value="modelValue"
		@input="$emit('update:modelValue', $event.target.value)"
	/>
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps({
	modelValue: String,
	withIcon: {
		type: Boolean,
		default: false,
	},
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
	if (input.value.hasAttribute('autofocus')) {
		input.value.focus();
	}
});

defineExpose({ focus: () => input.value.focus() });
</script>
