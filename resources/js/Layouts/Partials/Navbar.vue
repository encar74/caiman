<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { handleScroll, isDark, scrolling, sidebarState, toggleDarkMode } from '@/Composables';
import { Inertia } from '@inertiajs/inertia';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Sidebar from 'primevue/sidebar';
import { computed, onMounted, onUnmounted, ref } from 'vue';

onMounted(() => {
	document.addEventListener('scroll', handleScroll);
});
onUnmounted(() => {
	document.removeEventListener('scroll', handleScroll);
});

const logout = () => {
	Inertia.post(route('logout'));
};

const user = computed(() => usePage().props.value.user);

const notifications = ref(false);
</script>

<template>
	<nav
		aria-label="secondary"
		:class="[
			'transform sticky top-0 z-1 px-4 py-2 sm:px-6 sm:py-4 bg-white flex items-center justify-end transition-transform duration-500 dark:bg-dark-600',
			{
				'-translate-y-full': scrolling.down,
				'translate-y-0': scrolling.up,
			},
		]"
	>
		<div class="flex items-center gap-3">
			<Button @click="() => toggleDarkMode()" class="p-button p-button-icon-only p-button-rounded p-button-text p-button-secondary">
				<Iconify :icon="isDark ? 'tabler:sun' : 'tabler:moon'" class="h-5 w-5" />
			</Button>

			<Button @click="notifications = true" class="p-button p-button-icon-only p-button-rounded p-button-text p-button-secondary">
				<Iconify icon="tabler:bell" class="h-5 w-5" />
			</Button>

			<Dropdown align="right" width="64" class="mx-2">
				<template #trigger>
					<button
						v-if="$page.props.jetstream.managesProfilePhotos"
						class="flex text-sm border-2 border-transparent rounded-md transition focus:outline-none focus:ring focus:ring-sky-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-600"
					>
						<img class="h-8 w-8 rounded-md shadow-md object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
					</button>

					<span v-else class="inline-flex rounded-md">
						<button
							type="button"
							class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white transition hover:bg-gray-50 hover:text-gray-700 dark:bg-dark-600 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-dark-400 focus:outline-none focus:ring focus:ring-sky-500 focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-600"
						>
							{{ $page.props.user.name }}

							<Iconify icon="tabler:chevron-down" class="w-4 h-4 ml-2" />
						</button>
					</span>
				</template>

				<template #content>
					<div class="block px-4 py-2 text-xs text-gray-400">Account</div>

					<div class="flex gap-2 px-4 pb-4 text-xs">
						<img class="h-8 w-8 shadow-md rounded-md object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
						<div class="truncate">
							<p class="truncate">{{ $page.props.user.name }}</p>
							<p class="truncate text-gray-400">{{ $page.props.user.email }}</p>
						</div>
					</div>

					<DropdownLink :href="route('profile.show')"> Manage account </DropdownLink>

					<DropdownLink v-if="user.is_admin" :href="route('telescope')"> Admin panel </DropdownLink>
					<DropdownLink v-if="user.is_store" :href="route('developer.index')"> Developer </DropdownLink>

					<div class="border-t border-gray-100 dark:border-gray-700"></div>

					<!-- Authentication -->
					<form @submit.prevent="logout">
						<DropdownLink tag="button" type="submit"> Log Out </DropdownLink>
					</form>
				</template>
			</Dropdown>
		</div>
		<!-- </div> -->
	</nav>

	<!-- Mobile bottom bar -->
	<div
		:class="[
			'transform fixed inset-x-0 bottom-0 z-1 w-screen flex items-center justify-between px-4 py-2 sm:px-6 sm:py-4 transition-transform duration-500 bg-white md:hidden dark:bg-dark-600',
			{
				'translate-y-full': scrolling.down,
				'translate-y-0': scrolling.up,
			},
		]"
	>
		<Link :href="route('dashboard.store')">
			<ApplicationLogo class="w-10 h-10 rounded-lg" />
			<span class="sr-only">K UI</span>
		</Link>
		<Button
			@click="sidebarState.isOpen = !sidebarState.isOpen"
			:icon="sidebarState.isOpen ? 'pi pi-times' : 'pi pi-bars'"
			class="!h-8 !w-8 p-button-text p-button-secondary p-button-rounded"
		/>
	</div>

	<Sidebar v-model:visible="notifications" :baseZIndex="1" position="right" class="!w-3/4 lg:(!w-1/4)">
		<Card class="shadow-none">
			<template #title>Notifications</template>
			<template #content>
				<ul class="max-h-100 overflow-auto">
					<li v-for="i in 20" class="flex items-center py-2 border-b gap-4">
						<div class="w-[3em] h-[3em] rounded flex items-center justify-center bg-blue-100 flex-shrink-0">
							<i class="pi pi-dollar text-xl text-blue-500"></i>
						</div>
						<p>
							<span class="font-bold">Richard Jones </span>
							<span>has purchased a blue t-shirt for <span class="text-blue-500">79.55€</span></span>
						</p>
					</li>
				</ul>
			</template>
			<template #footer>
				<div class="flex justify-between">
					<Button class="p-button-sm">Clear</Button>
					<NavLink :href="null" class="gap-1">
						<span>View all</span>
						<Iconify icon="tabler:arrow-narrow-right" class="w-5 h-5" />
					</NavLink>
				</div>
			</template>
		</Card>
	</Sidebar>
</template>
