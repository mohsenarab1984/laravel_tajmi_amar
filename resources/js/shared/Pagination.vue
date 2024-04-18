<template>
    <div style="display: flex; gap: 30px">
        <Component
            :is="link.url ? 'Link' : 'span'"
            v-for="link in links"
            :href="link.url"
            :key="link.label"
            v-html="link.label"
            :class="{ 'text-gray-500': link.url, 'font-bold': link.active }"
        />
    </div>
</template>
<script setup>
import { ref } from "vue";
defineProps({ links: Array });
</script>
