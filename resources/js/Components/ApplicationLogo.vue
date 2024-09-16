<script setup>
import { isDark, sidebarState } from '@/Composables';
import { SquareLightLogo, SquareDarkLogo, WideLightLogo, WideDarkLogo } from '@/Components/Icons/Logos';
import { computed } from 'vue';

const isOpen = computed(() => sidebarState.isOpen || sidebarState.isHovered);
</script>

<template>
	<SquareLightLogo v-if="!isOpen && !isDark" />
	<SquareDarkLogo v-else-if="!isOpen && isDark" />
	<WideLightLogo v-else-if="isOpen && !isDark" />
	<WideDarkLogo v-else-if="isOpen && isDark" />
</template>
