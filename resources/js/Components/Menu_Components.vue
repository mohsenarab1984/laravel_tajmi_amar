<template>

      

      <div id="menu_component" class="mb-1" style="border: 1px solid #ccc; max-width: 1000px; padding: 5px 10px; background-color: #eee; justify-content: space-between;">
                 <div class=" d-flex justify-space-between">

                        <div v-if="!show_edit" class="menu_title d-inline-block" style=" "   > 
                            
                            
                              {{ menu.title }}
                        </div>
                          
                        <div class="d-inline-block">
        
                                <input v-if="show_edit" v-model="data_form.title" type="text" class="form-control menu_input"  placeholder="نام منو"   style="max-width: 400px; display: inline-block;">
                                  
                                  
                                <div v-if="!show_edit" class="d-inline-block" >
                                        
                                        <div>
        
                                            <button class="btn btn-sm edit mx-1 item_btn " id="item_create"  @click="toggle_show_item_create" > ساخت آیتم  </button>
            
                                            <button class="btn btn-warning btn-sm edit mx-1 " id="edit"  @click="show_edit=!show_edit" > ویرایش  </button>
                                            <button class="mx-1 btn btn-danger btn-sm edit " id="delete"  @click="confirmDelete" > X  </button>
                                            <button class="mx-1 btn btn-primary btn-sm edit " id="delete"    title="ساخت زیر منو" @click="set_show_submenu_create">  +    </button>
                                        </div>
                                        
                                          
                                        <!-- <button class="mx-1 btn btn-secondary btn-sm edit " id="delete"    title="ساخت زیر منو" @click="toggle_show_submenu_list" >  زیر منوها    </button> -->
                                        <!-- <button class="btn btn-success btn-sm edit mx-2" id="edit"  @click="()=>btnClickEdit(menu.id)" > اضافه کردن زیر منو </button> -->
                                  
                
                                    
                                </div>
        
                                <div  v-if="show_edit" class="d-inline-block my-1 ">
                          
                                      <button class="btn btn-primary btn-sm  " @click="updateMenu"  >   اعمال تغییرات </button>
                                      <button class="btn btn-secondary cancel mx-3 btn-sm"    @click="show_edit=!show_edit; data_form.title=menu.title ">   لغو   </button>
                                </div>
                              
        
                        </div>
                 </div>
                 <div>
                                          <button class="btn btn-sm" @click="toggle_show_submenu_list" v-show="false">
                                           
                                            <span v-if="!show_submenu_list && sub_menus.length>0 " class="cursor-pointer fw-bold mx-2" >+ </span>   
                                            <span v-if="show_submenu_list && sub_menus.length>0 " class="cursor-pointer fw-bold mx-2"  >- </span>
                                            <span> مشاهده ی زیرمنو </span>
                                            <span> ({{ sub_menus.length }}) </span>
                                          
                                          </button>

                                          <button class="btn btn-sm" @click="toggle_show_subItem_list" v-show="false">
                                           
                                            <span v-if="!show_subItems_list && menu.items.length" class="cursor-pointer fw-bold mx-2" >+ </span>   
                                            <span v-if="show_subItems_list && menu.items.length" class="cursor-pointer fw-bold mx-2"  >- </span>
                                            <span> مشاهده ی گزارش ها </span>
                                            <span> ({{ menu.items.length }})</span>
                                          
                                          </button>

                                          <button class="btn btn-sm" @click="toggle_show_subinfo">
                                           
                                            <span v-if="!show_subItems_list && (menu.items.length + sub_menus.length)" class="cursor-pointer fw-bold mx-2" >+ </span>   
                                            <span v-if="show_subItems_list && (menu.items.length + sub_menus.length)" class="cursor-pointer fw-bold mx-2"  >- </span>
                                            <span> مشاهده ی  اطلاعات </span>
                                            <span> ({{ menu.items.length + sub_menus.length  }})</span>
                                          
                                          </button>
                  </div>
             
                   <!-- <div v-if="form_operation.errors.title" class="color_red">{{ form_operation.errors.title }}</div> -->
         </div>

         <div v-show="show_item_create" >
                              <Item_Components :menu="menu" @toggle_show="toggle_show_item_create"/>
                            
          </div>

          <Create_Menu_Component v-if="show_submenu_create" :operation="operation" :parent_menu="menu" @cancelCreateMenu="set_show_submenu_create(false)"
          @successCreateMenu="successCreateMenuFunction" class="px-5" /> 

        

         <div class="px-5" v-if="menu" style="">
           
            <div v-if="show_submenu_list">
              <!-- <Menu_List :menus="sub_menus" :operation="operation"  /> -->
              <Menu_List :menus="menus" :parent_menu="menu" :operation="operation"  />
            </div>


         </div>

         <Items :items="menu.items" :parent_menu="menu" :show="show_subItems_list"  />
         <!-- <Item class="mx-5" v-for="item in menu.items " :item="{...item}" style="background: #def1d9;" /> -->

           
       

</template>
<script setup>

import { ref,watch, watchEffect,computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import _ from 'lodash'
import axios from 'axios'
import Swal from 'sweetalert2' 
import { router } from '@inertiajs/vue3';

import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';

import 'sweetalert2/dist/sweetalert2.min.css'

import Create_Menu_Component from './Create_Menu_Component.vue';
import Menu_List from './Menu_List.vue';
import Item_Components from './Item_Components.vue';

import Item from './Item.vue';
import Items from './Items.vue';

const props = defineProps({
    menu: Object,
    menus:Array,
    operation: Object
})

 

const show_submenu_list = ref(false)
const show_subItems_list = ref(false)
const show_submenu_create = ref(false)
const show_item_create = ref(false)

 const sub_menus=ref([])


function set_show_submenu_list(val=true){
  show_submenu_list.value = val
}

function toggle_show_submenu_list(){
  show_submenu_list.value = !show_submenu_list.value
}
function toggle_show_subItem_list(){
  show_subItems_list.value = !show_subItems_list.value
}
function toggle_show_subinfo(){
  show_subItems_list.value = !show_subItems_list.value
  show_submenu_list.value = !show_submenu_list.value
}

function set_show_submenu_create(val=true){
  show_submenu_create.value = val
}
function set_show_item_create(val=true){
  show_item_create.value = val
}
function toggle_show_item_create(){
  show_item_create.value = ! show_item_create.value 
}

function successCreateMenuFunction(){
  set_show_submenu_list()
}

const confirmDelete = () => {  
  Swal.fire({  
    title: 'Are you sure?',  
    text: "You won't be able to revert this!",  
    icon: 'warning',  
    showCancelButton: true,  
    confirmButtonText: 'Yes, delete it!',  
    cancelButtonText: 'Cancel'  ,
    customClass: {  
      popup: 'my-custom-popup',  
      cancelButton: 'my-custom-button',  
      confirmButton: 'my-custom-button'  
    },  
    didOpen: () => {  
      //document.querySelector('.swal2-popup').style.position = 'fixed';  
    }   
  }).then((result) => {  
    if (result.isConfirmed) {  
      deleteItem()  
    }  
  })  
}  

const deleteItem = () => {  
  console.log('Item is Deleted')

  router.delete(`/admin/menu/${props.menu.id}/`,{
    onSuccess(response){
              console.error('response: ',error)
              toast.success('عملیات با موفقیت انجام شد')
            }, onError(responnse){
              
              toast.error('عملیات با شکست انجام شد')
            },
            preserveScroll: true
  })

}  

console.log('05/17 menu: ',props.menu)


const data_form = useForm({
       title: null,
})

// const form_menu_create = useForm({
//       title: null,
//       parent_id: 0,
//       operation_id:0
//     })

const show_edit=ref(false)
const not_show = computed(()=>show_edit)


function toggleShowEdit( arg_value = null){
   show_edit.value = arg_value === null ? !show_edit.value  : arg_value
}

const menu_id = ref(null)

watchEffect(() => {  
    data_form.title = props.menu.title
    menu_id.value = props.menu.id
    sub_menus.value = props.menus.filter(menu =>menu.parent_id == props.menu.id) 
   // form_menu_create.parent_id = props.menu.id
    //form_menu_create.operation_id = props.operation.id
});  


function updateMenu(){

            data_form.post(`/admin/menu/${menu_id.value}/`,{
                onError: (errors) => {
                             toast.error('An error occurred !@! Please try again.');
                
               }
               ,
                onSuccess:(response)=>{
                            toggleShowEdit(false)
                            toast.success(' !@!   عملیات جدید با موفقیت ساخته شد')
                },
                preserveScroll:true
            })
    
}

</script>

<style>
/* Add this CSS to your component style section or global CSS file */  
.my-custom-popup {  
  border-radius: 10px;  
  background-color: #f3f3f3;  
  color: #333;  
}  

.my-custom-button {  
  color: white;  
  background-color: #007bff;  
}

.cursor-pointer{
  cursor: pointer;
}

.item_btn{
     background-color: greenyellow ;
}

</style>