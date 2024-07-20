<template>
    <h3>
      ساخت عملیات
    </h3>
      <div>
              <div class="mb-3">
                  <label for="title" class="form-label">عنوان عملیات</label>
                  <input type="text" class="form-control w_500 d-inline-block" id="title" v-model="form_operation.title">
                  <button class="btn btn-primary " @click="operation_title_edit" > ویرایش </button>
                  <div v-if="form_operation.errors.title" class="color_red">{{ form_operation.errors.title }}</div>
              </div>

              <hr>

              <!-- <div class="mb-3">
                  
                  <input type="text" class="form-control w_500 d-inline-block" id=" " v-model="form_menu_create.title" placeholder="نام منو" style="height: 30px;">
                  <button class="btn btn-primary btn-sm mx-3 " @click="create_menu" > ایجاد منو </button>
                  <div v-if="form_menu_create.errors.title" class="color_red">{{ form_menu_create.errors.title }}</div>
                  <div v-if="form_menu_create.errors.operation_id" class="color_red">{{ form_menu_create.errors.operation_id }}</div>
                  
              </div> -->
              <Create_Menu_Component :operation="operation" :parent_menu="null" />

              <!-- <Menu_Components v-for="menu in form_operation.menus" :menu="menu" :operation="operation" /> -->

              <Menu_List :menus="form_operation.menus" :parent_menu="null" :operation="operation"  />

               
      </div>
  
        
    </template>
    
    <script setup>
    import { ref,watch, watchEffect } from 'vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import _ from 'lodash'
    import axios from 'axios'
  
    import { toast } from 'vue3-toastify'
    import 'vue3-toastify/dist/index.css';

    import Menu_Components from '@com/Menu_Components.vue';
    import Create_Menu_Component from '@Components/Create_Menu_Component.vue';
import Menu_List from '../../../Components/Menu_List.vue';

    const props = defineProps(['operation','menus'])

    const page = usePage()
    console.log('page:',page.props)
   
    const form_menu_create = useForm({
      title: null,
      parent_id: 0
    })
    
    const form_operation = useForm({
         title: props.operation.title,
         operation_id: props.operation.id,
         menus : props.menus,
         menu: null
             
   })


  //  function create_menu(){
  //       form_menu_create
  //       .transform((data)=>({
  //         ...data,
  //         operation_id: props.operation.id
  //       }))
  //       .post("/admin/menu/save",{
  //           onError: (errors) => {
  //                       console.error("Error::",errors)
  //                       toast.error('An error occurred. Please try again.');
  //           }
  //         ,
  //           onSuccess:(response)=>{
  //              toast.success('منوی جدید با موفقیت ساخته شد')
  //              var new_obj = {id:props.operation.id, value:false}
              
  //           },
  //           preserveScroll:true
  //       })
  //    }

   watch(() => props.menus, (newVal, oldVal) => {  
        console.log('@ww watch props.menus changed:', newVal);  
        form_operation.menus = newVal.map(m=>({...m}))
     
}, { deep: true });  



  </script>


    
  <style>
    .color_red {
      color: red;
    }
  
    
  /* Add more specific CSS rules to style the toast messages */
  .vue-toastify {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
  }
  
  .vue-toastify .toast {
    margin-bottom: 10px;
    border-radius: 5px;
    padding: 10px 20px;
  }
  
  .vue-toastify .toast.toast-success {
    background-color: #4caf50; /* Green background for success messages */
    color: #fff; /* White text color for success messages */
  }
  
  .vue-toastify .toast.toast-error {
    background-color: #f44336; /* Red background for error messages */
    color: #fff; /* White text color for error messages */
  }
  
  .vue-toastify .toast.toast-warning {
    background-color: #ff9800; /* Orange background for warning messages */
    color: #fff; /* White text color for warning messages */
  }
    /* Add your custom styles here or use Bootstrap classes */

    .w_500 {
      width: 500px;
    }

    .d_inline_w{
       width: 400px;
       display: inline-block;
    }
    </style>