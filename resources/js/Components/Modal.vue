<template>
	<teleport to="body">
		<div v-show="show" class="grid fixed z-4 top-0 left-0 w-full h-full bg-black/50 overflow-auto px-4 py-6" :class="alignClass">
			<transition
				enter-active-class="ease-out duration-300"
				enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
				enter-to-class="opacity-100 translate-y-0 sm:scale-100"
				leave-active-class="ease-in duration-200"
				leave-from-class="opacity-100 translate-y-0 sm:scale-100"
				leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
			>
				<div ref="target" class="bg-white rounded-lg shadow-xl sm:w-full sm:mx-auto dark:bg-dark-400" :class="maxWidthClass">
					<slot v-if="show"></slot>
				</div>
			</transition>
		</div>
	</teleport>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { onClickOutside } from '@vueuse/core';

const props = defineProps({
	show: {
		type: Boolean,
		default: false,
	},
	maxWidth: {
		type: String,
		default: '2xl',
	},
	closeable: {
		type: Boolean,
		default: true,
	},
	align: {
		type: String,
		default: 'center',
	},
});

const emit = defineEmits(['close']);

watch(
	() => props.show,
	() => {
		if (props.show) {
			document.body.style.overflow = 'hidden';
		} else {
			document.body.style.overflow = null;
		}
	},
);

const close = () => {
	if (props.closeable) {
		emit('close');
	}
};

const closeOnEscape = (e) => {
	if (e.key === 'Escape' && props.show) {
		close();
	}
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
	document.removeEventListener('keydown', closeOnEscape);
	document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
	return {
		sm: 'sm:max-w-sm',
		md: 'sm:max-w-md',
		lg: 'sm:max-w-lg',
		xl: 'sm:max-w-xl',
		'2xl': 'sm:max-w-2xl',
	}[props.maxWidth];
});

const alignClass = computed(() => {
	return {
		'top-left': 'items-start justify-start',
		'top-center': 'items-start justify-center',
		'top-right': 'items-start justify-end',
		'center-left': 'items-center justify-start',
		center: 'place-items-center',
		'center-right': 'items-center justify-end',
		'bottom-left': 'items-end justify-start',
		'bottom-center': 'items-end justify-center',
		'bottom-right': 'items-end justify-end',
	}[props.align];
});

const target = ref(null);
onClickOutside(target, () => close());
</script>
