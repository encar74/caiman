<script setup lang="ts">
import { ref, computed } from 'vue';
import Checkbox from '../Checkbox.vue';
import { Filter } from './types';

interface Props {
	selected: Array<string>;
	filter: Filter;
}

const emits = defineEmits(['update:selected']);
const props = defineProps<Props>();

const proxy = computed({
	get: () => props.selected,
	set: (val) => emits('update:selected', val),
});
</script>

<template>
	<div class="p-3">
		<h1 class="text-xs text-gray-400">{{ filter.title }}</h1>
		<label v-for="option in filter.options" class="flex text-sm items-center">
			<Checkbox v-model:checked="proxy" :value="option.key" />
			<span class="whitespace-nowrap truncate">{{ option.label ? option.label : option.key }}</span>
		</label>
	</div>
</template>
