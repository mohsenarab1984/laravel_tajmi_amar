<template>
    <h3>
      ساخت عملیات
    </h3>
      <div>
              <div class="mb-3">
                  <label for="title" class="form-label">عنوان عملیات</label>
                  <input type="text" class="form-control" id="title" v-model="form_operation.title">
                  <button class="btn btn-primary " @click="operation_title_edit" > ویرایش </button>
                  <div v-if="form_operation.errors.title" class="color_red">{{ form_operation.errors.title }}</div>
              </div>

              <hr>

              <div class="mb-3">
                  <label for="title" class="form-label">  نام منو</label>
                  <input type="text" class="form-control w_500 d-inline-block" id=" " v-model="form_menu_create.title">
                  <button class="btn btn-primary " @click="create_menu" > ذخیره </button>
                  <div v-if="form_menu_create.errors.title" class="color_red">{{ form_menu_create.errors.title }}</div>
                  <div v-if="form_menu_create.errors.operation_id" class="color_red">{{ form_menu_create.errors.operation_id }}</div>
                  <!-- <div v-for="error in form_menu_create.errorsle" class="color_red">{{ error }}</div> -->
              </div>
              
              <div id="menu_component" class="mb-3" v-for="menu in form_operation.menus">
                  <div style="width: 400px; display: inline-block;" v-if="!show(menu.id)" class="menu_title"> {{ menu.title }}</div>
                  <input type="text" class="form-control menu_input" v-else placeholder="نام منو" :value="getUpdatedMenu(menu.id)" style="width: 400px; display: inline-block;"
                    @input="handle_change__input_menu(menu.id,$event.target.value)">
                   
                  <div v-if="!show(menu.id)" class="d-inline-block" >
                        <div >

                          <button class="btn btn-warning btn-sm edit " id="edit"  @click="()=>btnClickEdit(menu.id)" > ویرایش منو </button>
                          <button class="btn btn-success btn-sm edit mx-2" id="edit"  @click="()=>btnClickEdit(menu.id)" > اضافه کردن زیر منو </button>
                        </div>

                       
                  </div>
                  <div v-if="!show(menu.id)" class="px-5" >
                          
                          <!-- <input type="text" class="form-control menu_input mt-2 d-inline-block"  placeholder="نام زیر منو" @input="handle_change__input_submenu(menu.id,$event.target.value)"  
                            style="width: 250px; height: 25px; "
                              >
                           <button class="btn border btn-sm mx-3">اضافه  <span>+</span> </button> -->


                  </div>
                  <div  v-else class="d-inline-block ">
                    
                      <button class="btn btn-primary  " @click="()=>operation_menu_edit(menu.id)"  >   اعمال تغییرات </button>
                      <button class="btn btn-secondary cancel "    @click="()=>btnClickCancelEdit(menu.id)">   لغو   </button>
                  </div>
                   <!-- <div v-if="form_operation.errors.title" class="color_red">{{ form_operation.errors.title }}</div> -->
              </div>
  
             
            
             
  
      </div>
  
        
    </template>
    
    <script setup>
    import { ref,watch, watchEffect } from 'vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import _ from 'lodash'
    import axios from 'axios'
  
    import { toast } from 'vue3-toastify'
    import 'vue3-toastify/dist/index.css';

    const props = defineProps(['operation','menus'])

    const page = usePage()
    console.log('page:',page.props)
    // const route = useRoute()
    // console.log('id:',route.value.params.id)



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

  //  const updated_menus = ref(props.menus ?? [])
  //  const shows_array = ref(form_operation.menus.map(m=>({id:m.id, value:false})))
   const updated_menus = ref([])
   const shows_array = ref([])

      function create_menu(){
        form_menu_create
        .transform((data)=>({
          ...data,
          operation_id: props.operation.id
        }))
        .post("/admin/menu/save",{
            onError: (errors) => {
                        console.error("Error::",errors)
                        toast.error('An error occurred. Please try again.');
            }
          ,
            onSuccess:(response)=>{
               toast.success('منوی جدید با موفقیت ساخته شد')
               var new_obj = {id:props.operation.id, value:false}
               ///shows_array.value = [...shows_array.value,{id:props.operation.id, value:false}]
               //updated_menus.value = [...updated_menus.value,{title:form_menu_create.title}]
                        
            },
            preserveScroll:true
        })
     }

   
   watch(() => form_operation.menus, (newVal, oldVal) => {  
             // Handle the changes to form_operation.menus here  
            console.log('@ww watch form_operation.menus changed:', newVal);  
}, { deep: true });  

   watch(() => props.menus, (newVal, oldVal) => {  
        // Handle the changes to form_operation.menus here  
        console.log('@ww watch props.menus changed:', newVal);  
        form_operation.menus = newVal.map(m=>({...m}))
        ////////updated_menus.value = newVal
        
       /////// shows_array.value=  newVal.map(m=>({id:m.id, value:false}))
        console.log('shows_array 1')
        // shows_array.value = newVal.map(m=>shows_array.value.some(s=>s.id == m.id) ? m : ({id:m.id, value:false}) )
}, { deep: true });  

watchEffect(() => {  
        updated_menus.value = props.menus
        
        const prev_show_array = shows_array.value.map(sh=>sh);
        console.log('prev_show_array: ',prev_show_array)
        console.log(' props.menus: ', props.menus)
        shows_array.value=  props.menus.map(m=>{

             const find_item =   shows_array.value.find(s=>s.id == m.id) 
             const new_value = find_item ? find_item['value'] : false
             return {id: m.id, value:new_value}
        })
        
        
        // ({id:m.id, value:prev_show_array.filter(p =>p == m.id)[value] ??  false}))
        console.log(' shows_array.value: ', shows_array.value)
    //console.log('wee[watchEffect]   shows_array.value: ', shows_array.value) 
   // console.log('wee[watchEffect]   updated_menus.value: ', updated_menus.value) 
});  

watch(shows_array, (newVal, oldVal) => {  
        // Handle the changes to form_operation.menus here  
        console.log('@ww  watch shows_array changed:', newVal.map(s=>s.value));  
        
       
}, { deep: true }); 



  

   const handle_change__input_menu = (menu_id, newValue)=>{
          console.log('form_operation.menus: ',form_operation.menus)
          console.log('updated_menus.value: ',updated_menus.value)

          console.log(menu_id, newValue)
          updated_menus.value = updated_menus.value.map(menu=>{
              if(menu.id == menu_id){
                  return { ...menu, title: newValue };  
                    // menu.title = newValue
                    // return menu
              }else{
                return menu
              }
          })
   }

   const handle_change_input_create_submenu = (menu_id, newValue)=>{
          
   }



   
   const show = (id)=>{
     const row = shows_array.value.find(row=>row.id == id )
     return row ? row['value'] : false
   } 

   const getUpdatedMenu = (menu_id)=>{
    const menu = updated_menus.value.find(m=>m.id == menu_id) ;
    return menu?.title
   }

   const btnClickEdit=(menu_id)=>{
      toggleShow_EditInput(menu_id)
   }

   const btnClickCancelEdit=(menu_id)=>{
      toggleShow_EditInput(menu_id)
      cancelUpdatedMenu(menu_id)
   }
   const cancelUpdatedMenu = (menu_id)=>{
              const menu_original = form_operation.menus.find(m=>m.id == menu_id) ;
              updated_menus.value = updated_menus.value.map(m=>m.id !=menu_id ? m : ({...menu_original}) )
            }

   const toggleShow_EditInput = (id, new_value=null)=>{
            shows_array.value = shows_array.value.map(row=>{
                  if(row.id != id)
                    return row
                  else{
                    row.value =new_value !==null ? new_value : !row.value
                    return row;
                  }
             }
          )

          console.log('shows_array 2: ',)

   }
  
    const operation_menu_edit = (menu_id) => {
      
      const menu = updated_menus.value.find(m=>m.id == menu_id) ;

      console.log('updated_menus: ',menu.title)
      //return ;
       
      form_operation.transform((data) => ({
     
        title: menu?.title
     }))
      .post(`/admin/menu/${menu_id}/`,{
            onError: (errors) => {
              console.error(errors);
             
                  toast.error('An error occurred. Please try again.');
             
          }
          ,
            onSuccess:(response)=>{
              ///const operationId = response.data.id;
              //const operationId = response.props.operationId;
              console.log('onSuccess__before shows_array  toggleShow_EditInput')
              toggleShow_EditInput(menu_id,false)
              console.log('onSuccess__after shows_array  toggleShow_EditInput')
              toast.success('عملیات جدید با موفقیت ساخته شد')
              // form_operation.clearErrors()
             
            },
            preserveScroll:true
        })
     };
 
 
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