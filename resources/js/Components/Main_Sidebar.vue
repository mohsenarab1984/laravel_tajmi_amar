<template>
<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline">Menu </span>
        </a>
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu" style="width:100%" >
             
            

            <li style="width:100%">
                <a href="#menu_operation_sidebar" data-bs-toggle="collapse" class="nav-link px-0 align-middle " onclick="return false">
                    <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">عملیات</span></a>
                <ul class="collapse nav flex-column ms-1 " id="menu_operation_sidebar" data-bs-parent="#menu" style="border-right: 1px solid rgb(204, 204, 204);padding-right:20px; background: #666;">
                    <li class="w-100">
                        <Link href="/operation/" class="nav-link px-0"> <span class="d-none d-sm-inline">      عملیات ها</span>  </Link>
                    </li>
                    <li class="w-100">
                        <Link href="/admin/operation/create" class="nav-link px-0"> <span class="d-none d-sm-inline">ساخت     عملیات</span>  </Link>
                    </li>
                   
                     
                </ul>
            </li>
            <li style="width:100%">
                <a href="#menu_report_sidebar" data-bs-toggle="collapse" class="nav-link px-0 align-middle " onclick="return false">
                    <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">گزارش</span></a>
                <ul class="collapse nav flex-column ms-1 " id="menu_report_sidebar" data-bs-parent="#menu" style="border-right: 1px solid rgb(204, 204, 204);padding-right:20px; background: #666;">
                    <!-- <li class="w-100">
                        <Link href="/admin/report/create" class="nav-link px-0"> <span class="d-none d-sm-inline">ساخت آیتم گزارش</span>  </Link>
                    </li> -->
                    <li class="w-100">
                        <Link href="/report" class="nav-link px-0"> <span class="d-none d-sm-inline">    مشاهده ی گزارش ها</span>  </Link>
                    </li>
                   
                     
                </ul>
            </li>

            <li style="width:100%">
                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle" onclick="return false">
                    <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">مدیریت کاربران</span> 
                </a>
                <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu" style="border-right: 1px solid rgb(204, 204, 204);padding-right:20px; background: #666; width:100%">
                    <li class="w-100">
                        <Link href="/admin/users" class="nav-link px-0"> <span class="d-none d-sm-inline"> مشاهده کابران </span>  </Link>
                    </li>
                    
                </ul>
            </li>
            
        </ul>
        <hr>
        
    </div>
</div>
</template>

<script setup>

</script>