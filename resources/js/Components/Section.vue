<template>
	<div class="grid gap-4 md:gap-6">
		<SectionTitle>
			<template #title><slot name="title"></slot></template>
			<template #description><slot name="description"></slot></template>
		</SectionTitle>

		<div class="mt-5 md:mt-0 md:col-span-2">
			<div class="rounded-lg px-4 py-5 bg-white shadow-md sm:p-6 dark:bg-dark-600">
				<div class="grid grid-cols-6 gap-6">
					<slot></slot>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import SectionTitle from '@/Components/SectionTitle.vue';
</script>
