<template>
    <Head>
        <title>Report View</title>
        <meta
            type="description"
            content="description about Home"
            head-key="description"
        />
    </Head>

    <div class="text-center">
       
        <h3>
            Report View
        </h3>
      
    </div>
  
</template>
<script setup>
defineProps(["username"]);
import { Link } from "@inertiajs/vue3";
 
// import { Head } from "@inertiajs/vue3"; //////////////// Head is Globally Registered By me in app.js ////
// import Layout from "../shared/Layout.vue"; //// used default layout
// defineOptions({ layout: Layout }); //// used default layout
</script>
