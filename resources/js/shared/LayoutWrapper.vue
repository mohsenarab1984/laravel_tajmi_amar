<!-- LayoutWrapper.vue -->
<template>
    <CustomLayout :isAdmin="is_admin">
        <slot />
    </CustomLayout>
</template>

<script setup>
import CustomLayout from "./Layout.vue";
import { usePage } from '@inertiajs/vue3';

defineProps(['isAdmin'])
const { page } = usePage();
const is_admin = page.props?.isAdmin;
</script>