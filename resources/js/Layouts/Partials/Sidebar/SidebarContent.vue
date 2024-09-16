<template>
	<PerfrectScrollbar tagname="nav" aria-label="main" class="relative flex flex-col flex-1 max-h-full gap-4 px-3">
		<template v-for="link in links">
			<SidebarLink v-if="!link.collapsible" v-show="link.show" :title="link.title" :href="link.url" :active="link.active">
				<template #icon>
					<Iconify :icon="link.icon" class="w-6 h-6" aria-hidden="true" />
				</template>
			</SidebarLink>
			<SidebarCollapsible v-else v-show="link.show" :title="link.title" :active="link.active" href="www.google.com">
				<template #icon>
					<Iconify :icon="link.icon" class="w-6 h-6" aria-hidden="true" />
				</template>

				<SidebarCollapsibleItem v-for="item in link.collapsible" :title="item.title" :href="item.url" :active="item.active"/>
			</SidebarCollapsible>
		</template>
	</PerfrectScrollbar>
</template>

<script setup>
import PerfrectScrollbar from '@/Components/PerfectScrollbar';
import SidebarLink from './SidebarLink.vue';
import SidebarCollapsible from './SidebarCollapsible.vue';
import SidebarCollapsibleItem from './SidebarCollapsibleItem.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const user = computed(() => usePage().props.value.user);

const links = [
	// ADMIN ROUTES
	{
		title: 'Dashboard',
		url: route('dashboard.admin'),
		active: route().current('dashboard.admin'),
		show: user.value.is_admin,
		icon: 'tabler:layout-dashboard'
	},
	{
		title: 'Users',
		url: route('users.index'),
		active: route().current('users.*'),
		show: user.value.is_admin,
		icon: 'tabler:users'
	},
	
	// STORE ROUTES
	{
		title: 'Dashboard',
		url: route('dashboard.store'),
		active: route().current('dashboard.store'),
		show: user.value.is_store,
		icon: 'tabler:layout-dashboard'
	},
	{
		title: 'Analytics',
		url: route('analytics.index'),
		active: route().current('analytics.*'),
		show: user.value.is_store,
		icon: 'tabler:presentation'
	},
	{
		title: 'Products',
		url: route('products.index'),
		active: route().current('products.*'),
		show: user.value.is_store,
		icon: 'tabler:shopping-bag'
	},
	{
		title: 'Inventory',
		url: route('inventory.index'),
		active: route().current('inventory.*'),
		show: user.value.is_store,
		icon: 'tabler:box-seam'
	},
];
</script>
