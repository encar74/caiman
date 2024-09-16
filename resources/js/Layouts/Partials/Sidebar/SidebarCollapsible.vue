<template>
	<div class="relative">
		<SidebarLink @click="isOpen = !isOpen" :title="title" :active="active">
			<template #icon>
				<slot name="icon">
					<EmptyCircleIcon aria-hidden="true" class="flex-shrink-0 w-6 h-6" />
				</slot>
			</template>

			<template #arrow>
				<span v-show="sidebarState.isOpen || sidebarState.isHovered" aria-hidden="true" class="relative block w-6 h-6 ml-auto">
					<span
						:class="[
							'transform absolute right-[12px] mt-[-5px] h-2 w-[2px] top-1/2 transition-all duration-200',
							{
								'-rotate-45': isOpen,
								'rotate-45': !isOpen,
							},
							{
								'bg-white': active,
								'bg-gray-400': !active,
							},
						]"
					></span>
					<span
						:class="[
							'transform absolute left-[12px] mt-[-5px] h-2 w-[2px] top-1/2 transition-all duration-200',
							{
								'rotate-45': isOpen,
								'-rotate-45': !isOpen,
							},
							{
								'bg-white': active,
								'bg-gray-400': !active,
							},
						]"
					></span>
				</span>
			</template>
		</SidebarLink>

		<transition @before-enter="beforeEnter" @enter="enter" @before-leave="beforeLeave" @leave="leave">
			<div v-show="isOpen && (sidebarState.isOpen || sidebarState.isHovered)" class="overflow-hidden transition-all duration-200">
				<ul
					class="relative px-0 pt-2 pb-0 ml-5 before:w-0 before:block before:absolute before:inset-y-0 before:left-0 before:border-l-2 before:border-l-gray-200 dark:before:border-l-gray-600"
				>
					<slot />
				</ul>
			</div>
		</transition>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { sidebarState } from '@/Composables';
import SidebarLink from './SidebarLink.vue';
import { EmptyCircleIcon } from '@/Components/Icons/Outline';

const props = defineProps({
	title: {
		type: String,
	},
	icon: {
		required: false,
	},
	active: {
		type: Boolean,
	}
});

const { active } = props;

const isOpen = ref(active);

const beforeEnter = (el) => {
	el.style.maxHeight = `0px`;
};
const enter = (el) => {
	el.style.maxHeight = `${el.scrollHeight}px`;
};
const beforeLeave = (el) => {
	el.style.maxHeight = `${el.scrollHeight}px`;
};
const leave = (el) => {
	el.style.maxHeight = `0px`;
};
</script>
