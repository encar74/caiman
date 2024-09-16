<template>
	<Modal :show="show" :max-width="maxWidth" :align="align" :closeable="closeable" @close="close">
		<div class="px-6 py-4 rounded-t-lg ">
			<div class="text-lg">
				<slot name="title"> </slot>
			</div>

			<div class="mt-4">
				<slot name="content"> </slot>
			</div>
		</div>

		<div v-if="slots.footer" class="rounded-b-lg px-6 py-4 text-right bg-gray-100 dark:bg-dark-200">
			<slot name="footer"> </slot>
		</div>
	</Modal>
</template>

<script setup>
import Modal from '@/Components/Modal.vue';
import { useSlots } from 'vue';

const slots = useSlots();
const emit = defineEmits(['close']);

defineProps({
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

const close = () => {
	emit('close');
};
</script>
