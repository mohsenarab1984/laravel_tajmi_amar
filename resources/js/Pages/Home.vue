<template>
    <Head>
        <title>Home</title>
        <meta
            type="description"
            content="description about Home"
            head-key="description"
        />
    </Head>

    <div class="text-center">

   صفحه اصلی
    </div>
  
</template>
<script setup>
defineProps(["username"]);
import { Link } from "@inertiajs/vue3";
import Nav from "../shared/Nav.vue";
// import { Head } from "@inertiajs/vue3"; //////////////// Head is Globally Registered By me in app.js ////
// import Layout from "../shared/Layout.vue"; //// used default layout
// defineOptions({ layout: Layout }); //// used default layout
</script>
