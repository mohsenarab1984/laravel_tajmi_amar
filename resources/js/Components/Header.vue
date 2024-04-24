<template>
    <!--offcanvas menu area start-->
    <div class="body_overlay"></div>
     

    <!--header area start-->
    <header class="header_section mb-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div
                        class="main_header d-flex justify-content-between align-items-center"
                    >
                        <div class="header_logo">
                            <div v-if="user" style="gap: 2rem!important; display: flex;">
                                <span>{{ user.name }}</span>
                                <Link href="/logout"   as="button"> خروج </Link>
                                <Link v-if="user && user.is_admin==0" href="/user/upload"   as="button"> آپلود </Link>

                                <!-- <span v-if="user.is_admin==1" class="mx-4 border rounded px-4 py-2 ">
                                    <Link> پنل ادمین </Link>
                                </span> -->
                            </div>
                            <div v-else style="gap: 2rem!important; display: flex;">
                                <Link  href="/login"  as="button">  ورود کاربر  </Link>
                                <Link  href="/admin/login" as="button" >  ورود ادمین  </Link>
                                
                            </div>
                           
                        </div>
                        <!--main menu start-->
                        <div class="main_menu d-none d-lg-block">
                            <nav>
                                <ul class="d-flex">
                                    <li v-if="user && user.is_admin==1">
                                       
                                             <Link href="/admin" > پنل ادمین </Link>
                                      
                                    </li>
                                    <li >
                                       <Link href="/"> Home </Link>
                                        <ul class="sub_menu">
                                            <li><a href="#">Home 1</a></li>
                                            <li><a href="#">Home 2</a></li>
                                        </ul>
                                    </li>
                                    
                                    
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </nav>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </header>
    
</template>
<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";


const page = usePage();

const user = computed(() => page.props.auth.user);
</script>
