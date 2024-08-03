<template>

      <div class="mb-3">
                  <!-- <label for="title" class="form-label">  نام منو</label> -->
                  <input type="text" class="form-control w_500 d-inline-block" id=" " v-model="form_menu_create.title" placeholder="نام منو" style="height: 30px;">
                  <button class="btn btn-primary btn-sm mx-3 " @click="create_menu" >    ذخیره </button>
                  <button class="btn btn-primary btn-sm mx-3 " @click="cancelCreateMenuClick" >    لغو </button>


                  <div v-if="form_menu_create.errors.title" class="color_red">{{ form_menu_create.errors.title }}</div>
                  <div v-if="form_menu_create.errors.operation_id" class="color_red">{{ form_menu_create.errors.operation_id }}</div>
                  <!-- <div v-for="error in form_menu_create.errorsle" class="color_red">{{ error }}</div> -->
       </div>   

</template>
<script setup>
import { ref,watch, watchEffect,computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { defineEmits } from 'vue';
import _ from 'lodash'
import axios from 'axios'
import { showErrorProps_Toast } from '@helpers/manage_errors';

import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';

const emit=defineEmits(['cancelCreateMenu','successCreateMenu'])
const page = usePage()

const props = defineProps(['operation','parent_menu'])

function cancelCreateMenuClick(){
   emit('cancelCreateMenu')
}

const page_url = page.url

const form_menu_create = useForm({
      title: null,
      parent_id: 0,
      operation_id:0
    })

    watchEffect(() => {  
           
            form_menu_create.parent_id = props.parent_menu?.id ?? 0
            form_menu_create.operation_id = props.operation.id

            
            console.log('form_menu_create: ',form_menu_create)
   }); 


function create_menu(){
        form_menu_create.post("/admin/menu/save",{
            onError: (errors) => {
                        console.error("Error::",errors)
                        console.error("page.props.errors::",page.props.errors)
                        showErrorProps_Toast(errors)
                      
            }
          ,
            onSuccess:(response)=>{

               // console.log('page.component: ',page.component,', page.url: ',page.url)
               // console.log('response.component: ',response.component,', response.url: ',response.url)
               // console.log('page_url: ',page_url)
               // response.status === 302
               

                  toast.success('منوی جدید با موفقیت ساخته شد')
                  console.log('response in Create component: ',response)
                  form_menu_create.title=null
                  emit('successCreateMenu')
             
              // emit('cancelCreateMenu')
             
            },
            preserveScroll:true
        })
     }


</script>