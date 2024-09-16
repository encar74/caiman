<script setup>
const props = defineProps({
	photo: String,
});
</script>

<template>
	<span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" :style="`background-image: url('${photo}')`"> </span>
</template>
