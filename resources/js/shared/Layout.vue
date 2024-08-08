<template>
    <Header />
    <Head>
        <title>My App</title>
        <meta
            type="description"
            content="description about my app"
            head-key="description"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </Head>
    <section class="bg-gray-200">
        <header class="flex justify-between">
            
            <!-- <p>weclome {{ username }}</p> -->
            <!-- <h6>Welcome, {{ user ? user.name : '-No user' }}</h6> -->

            <!-- <Nav /> -->
        </header>
    </section>
    <!-- <section class="p-6" style="min-height:400px">
        <div class="max-w-3xl mx-auto">
           
        </div>
    </section> -->



    <div class="container-fluid" style="direction: rtl; min-height: 400px;">
            <div class="row flex-nowrap">
                <slot name="admin_slot">
                    <Main_Sidebar v-if="page.props.auth?.user"   />
                    <!-- <Cartabl_Sidebar v-if="page.props.auth?.user && page.props.auth?.user.is_admin !=1" /> -->
                </slot>
                <!-- <Admin_Sidebar /> -->
                <div class="col py-3">
                    <slot />
                </div>
            </div>
   </div>







    <Footer />
</template>
<script setup>
import Nav from "./Nav.vue";
import { computed, watch, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import Header from "../Components/Header.vue";
import Footer from "../Components/Footer.vue";

import Main_Sidebar from "@com/Main_Sidebar.vue";
import Cartabl_Sidebar from "@Components/Cartabl_Sidebar.vue";


// const props = defineProps(["auth"]);

const page = usePage();

console.log("page.props.user: ", page.props.auth.user);
console.log("page.props: ", page.props);

const user = computed(() => page.props.auth.user);

// watchEffect(() => {
//     console.log("usePage(): ", usePage().props.value);
// });

// const { auth } = usePage().props;
// const user = auth.user;

// console.log("usepage", usePage());
// watch(username, (username_w) => {
//     console.log("username_w: ", username_w);
// });
</script>
