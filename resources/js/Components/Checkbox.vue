<template>
    <input 
        type="checkbox" 
        :value="value" 
        v-model="proxyChecked"
        class="m-2 text-sky-500 border-gray-300 rounded focus:border-sky-300 focus:ring focus:ring-sky-500 dark:border-gray-600 dark:bg-dark-600 dark:focus:ring-offset-dark-600">
</template>

<script setup>
import { computed } from 'vue'

const emit = defineEmits(['update:checked'])

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
})

const proxyChecked = computed({
    get() {
        return props.checked
    },

    set(val) {
        emit('update:checked', val)
    },
})
</script>
