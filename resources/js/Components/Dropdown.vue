<script setup>
import { onClickOutside } from '@vueuse/core';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
	align: {
		type: String,
		default: 'right',
	},
	width: {
		type: String,
		default: '48',
	},
	contentClickable: {
		type: Boolean,
		default: false,
	},
	contentClasses: {
		type: Array,
		default: () => ['py-1', 'bg-white dark:bg-dark-600'],
	},
});

let open = ref(false);

const closeOnEscape = (e) => {
	if (open.value && e.key === 'Escape') {
		open.value = false;
	}
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
	return {
		48: 'w-48',
		64: 'w-64',
	}[props.width.toString()];
});

const alignmentClasses = computed(() => {
	if (props.align === 'left') {
		return 'origin-top-left left-0';
	}

	if (props.align === 'right') {
		return 'origin-top-right right-0';
	}

	return 'origin-top';
});

onClickOutside(open, () => (open.value = false));
</script>

<template>
	<div class="relative">
		<div @click="open = !open">
			<slot name="trigger" />
		</div>

		<transition
			enter-active-class="transition ease-out duration-200"
			enter-from-class="opacity-0 scale-95"
			enter-to-class="opacity-100 scale-100"
			leave-active-class="ease-in duration-75"
			leave-from-class="opacity-100 scale-100"
			leave-to-class="opacity-0 scale-95"
		>
			<div ref="target" v-show="open" class="absolute z-50 mt-2 rounded-md shadow-lg" :class="[widthClass, alignmentClasses]" style="display: none" @click="open = contentClickable">
				<div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
					<slot name="content" />
				</div>
			</div>
		</transition>
	</div>
</template>
