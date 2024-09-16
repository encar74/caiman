<script setup lang="ts">
interface Item {
	key: string;
	value: string;
	description: string;
}

const emits = defineEmits(['update:modelValue']);
const props = defineProps({
	modelValue: null,
	items: Array<Item>,
});
</script>

<template>
	<div class="relative mt-1 border border-gray-200 rounded-lg cursor-pointer dark:border-gray-600">
		<button
			v-for="(item, i) in items"
			:key="item && item.key"
			type="button"
			class="relative px-4 py-3 inline-flex w-full rounded-lg focus:outline-none focus:ring focus:ring-sky-500"
			:class="{ 'border-t border-gray-200 rounded-t-none dark:border-gray-600': i > 0, 'rounded-b-none': items && i !== items.length - 1 }"
			@click="emits('update:modelValue', item.key)"
		>
			<div :class="{ 'opacity-70': modelValue !== item.key }">
				<!-- Item Name -->
				<div class="flex items-center">
					<div class="text-sm text-gray-600 dark:text-gray-400" :class="{ 'font-semibold': modelValue === item.key }">
						{{ item.value }}
					</div>

                    <Iconify v-if="modelValue === item.key" icon="tabler:circle-check" class="ml-2 h-5 w-5 text-green-400" />
				</div>

				<!-- Item Description -->
				<div class="mt-2 text-xs text-gray-600 text-left dark:text-gray-400">
					{{ item.description }}
				</div>
			</div>
		</button>
	</div>
</template>
