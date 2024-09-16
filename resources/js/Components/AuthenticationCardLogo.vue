<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { isDark, sidebarState } from '@/Composables';
import { WideLightLogo, WideDarkLogo } from '@/Components/Icons/Logos';

</script>

<template>
    <Link :href="'/'">
        <WideLightLogo v-if="isDark" />
        <WideDarkLogo v-else/>
    </Link>
</template>
