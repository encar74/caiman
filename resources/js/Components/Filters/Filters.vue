<script setup lang="ts">
import FilterTag from './FilterTag.vue';
import Button from '../Button.vue';
import Dropdown from '../Dropdown.vue';
import FilterSelect from './FilterSelect.vue';
import { computed } from 'vue';
import { Filter } from './types';

interface Props {
	filters: Array<Filter>;
	form: Object;
}

const emits = defineEmits(['update:form']);
const props = defineProps<Props>();

const proxyForm = computed({
	get: () => props.form,
	set: (form) => emits('update:form', form),
});
</script>

<template>
	<div class="flex flex-col gap-3 items-end md:flex-row">
		<Dropdown align="left" width="48" :content-clickable="true">
			<template #trigger>
				<Button variant="primary" size="sm" pill>Filters<Iconify icon="tabler:filter" /></Button>
			</template>
			<template #content>
				<FilterSelect v-for="filter in filters" :key="`filter-select-${filter.title}`" v-model:selected="proxyForm[filter.key]" :filter="filter" />
			</template>
		</Dropdown>

		<div class="flex flex-wrap gap-x-3 gap-y-2 md:justify-end">
			<FilterTag v-for="filter in filters" :key="`filter-tag-${filter.title}`" v-model:selected="proxyForm[filter.key]" :title="filter.title" />
		</div>
	</div>
</template>
