<script setup lang="ts">
import Button from '../Button.vue';

interface Props {
	selected: Array<string>,
	title: string
}
const emits = defineEmits(['update:selected']);
defineProps<Props>();

const deleteFilter = () => {
	emits('update:selected', []);
};
</script>

<template>
	<Button v-if="selected.length > 0" variant="alternative" size="sm" pill class="bg-gray-200 dark:(bg-gray-800 hover:text-gray-400 hover:bg-gray-700)">
		<span>{{ title }}:</span>
		<span v-for="(tag, index) in selected">
            {{ tag }}<span v-if="index < selected.length - 1">,</span>
        </span>
		<Iconify @click="deleteFilter" icon="tabler:x" />
	</Button>
</template>
