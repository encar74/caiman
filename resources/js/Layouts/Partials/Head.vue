<script>
import { Head as InertiaHead } from '@inertiajs/inertia-vue3';
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Head',
    props: {
        title: String
    },
    components: {
        InertiaHead
    }
})
</script>

<template>
	<InertiaHead :title="title" />
</template>
