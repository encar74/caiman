<template>
	<Head :title="title" />

	<div class="min-h-screen pb-16 md:pb-0 bg-gray-100 text-gray-900 dark:bg-dark-800 dark:text-gray-100">
		<Sidebar />

		<div
			style="transition-property: margin; transition-duration: 150ms"
			:class="[
				'min-h-screen flex flex-col',
				{
					'lg:ml-64': sidebarState.isOpen,
					'md:ml-16': !sidebarState.isOpen,
				},
			]"
		>
			<Banner />

			<Navbar />

			<!-- Page Content -->
			<main class="flex-1 px-4 max-w-10xl w-full mx-auto sm:px-6 lg:px-8">
				<!-- Page Heading -->
				<header v-if="$slots.header">
					<div class="py-6">
						<slot name="header"></slot>
					</div>
				</header>
				<slot v-if="$slots.default"></slot>
			</main>

			<PageFooter />
		</div>
	</div>
</template>

<script setup>
import { sidebarState } from '@/Composables';
import Head from './Partials/Head.vue';
import Banner from './Partials/Banner.vue';
import Sidebar from './Partials/Sidebar/Sidebar.vue';
import Navbar from './Partials/Navbar.vue';
import PageFooter from './Partials/PageFooter.vue';

defineProps({
	title: {
		type: String,
		default: '',
	},
});
</script>
