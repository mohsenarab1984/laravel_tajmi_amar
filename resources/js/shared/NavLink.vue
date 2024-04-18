<template>
    <Link class="text-black hover:underline" :class="{ 'font-bold': active }">
        <slot />
    </Link>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps(["active"]);
import { ref } from "vue";
</script>
