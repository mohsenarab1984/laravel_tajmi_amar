<template>
     
    <div>
            <div class="my-3 d-inline-block">
                <label for="title" class="form-label  d-inline-block ms-3">عنوان  آیتم : </label>
                <input type="text" class="form-control d-inline-block" id="title" v-model="form.title" style="width: 400px;">
              
                <div v-if="form.errors.title" class="color_red">{{ form.errors.title }}</div>
            </div>

            <div class="mb-3 d-inline-block">
                <div for="title" class="form-label ms-2 me-5" style="display: inline-block;">نوع : </div>
                 <select v-model="form.type" class="form-control d-inline-block" style="width: 100px;" >
                     <option value="number"> عددی </option>
                     <option value="tick"> تیک </option>
                 </select>
                <div v-if="form.errors.type" class="color_red">{{ form.errors.type }}</div>
            </div>

            <div class="mb-3 d-inline-block">
                <div for="title" class="form-label ms-2 me-5" style="display: inline-block;">نوع : </div>
                <input type="text" class="form-control d-inline-block" id="min" v-model="form.min" style="width: 150px;">
                 
                <div v-if="form.errors.min" class="color_red">{{ form.errors.min }}</div>
            </div>

            <div class="mb-3 d-inline-block">
                <div for="title" class="form-label ms-2 me-5" style="display: inline-block;">نوع : </div>
                <input type="text" class="form-control d-inline-block" id="min" v-model="form.max" style="width: 150px;">
                 
                <div v-if="form.errors.max" class="color_red">{{ form.errors.max }}</div>
            </div>

             <div>

             </div>

            <div class="mb-3  d-inline-block">
                <div for="title" class="form-label d-inline-block" >نام  وارد کننده :  </div>
                <SearchName   :show="showSearchBox.adder" @close_search="close_seach_fn"  @selectRowEmit="(res)=>updaterResults(res,'adder')" @clickSearchIcon="showSearchBox.adder=true" 
                   class="d-inline-block" />  
                
                <div v-if="form.errors.adder_id" class="color_red">{{ form.errors.adder_id }}</div>
            </div>

            <div class="mb-3  d-inline-block me-5">
                <div for="title" class="form-label d-inline-block" >نام    تایید کننده :  </div>
                <SearchName   :show="showSearchBox.verifier" @close_search="close_seach_fn"  @selectRowEmit="(res)=>updaterResults(res,'verifier')" @clickSearchIcon="showSearchBox.verifier=true" 
                   class="d-inline-block" />  
                
                <div v-if="form.errors.verifier_id" class="color_red">{{ form.errors.verifier_id }}</div>
            </div>

            <div class="mb-3  d-inline-block me-5">
                <div for="title" class="form-label d-inline-block" >نام    مشاهده کننده :  </div>
                <SearchName   :show="showSearchBox.viewer" @close_search="close_seach_fn"  @selectRowEmit="(res)=>updaterResults(res,'viewer')" @clickSearchIcon="showSearchBox.viewer=true" 
                   class="d-inline-block" />  
                
                <div v-if="form.errors.viewer_id" class="color_red">{{ form.errors.viewer_id }}</div>
            </div>

             
            <div v-if="form.errors">
                    <div v-for="error in form.errors" class="color_red"> {{ error }} </div>
            </div>
            <div class=" mt-2 mb-3 me-5" style="display: flex;  gap: 50px;">

              <button class="btn btn-success btn-sm " @click="sendData">ذخیره</button>
              <button class="btn btn-secondary btn-sm mx-3" @click="emit('toggle_show')">کنسل</button>
            </div>

    </div>

      
  </template>
  
  <script setup>
  import { reactive, ref, watchEffect } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import _ from 'lodash'
  import axios from 'axios'

  import { toast } from 'vue3-toastify'
  import 'vue3-toastify/dist/index.css';
//   import Modal from './Modal.vue';

const props = defineProps(['menu'])
const emit = defineEmits(['toggle_show'])


  import { Modal } from 'usemodal-vue3';
  import  ModalCustomized from './Modal.vue';
  import MyModal from './MyModal.vue';
  import SearchName from './SearchName.vue';

  
const form_search = useForm({
       adder_name:'',
       adder_id:null,
       adder_results:null,
       verifier_name:'',
       viewer_id:null,
       viewer_results:null,
       viewer_name:'',
       verifier_id: null,
       verifier_results: null,
       title:'',
       operation_id: null
})


const form = useForm({
      title:'',
      type:'',
      adder_id:null,
      viewer_id:null,
      verifier_id: null,
      menu_id: null,
      min: null,
      max: null
})

  watchEffect(()=>{
    form.menu_id = props.menu?.id ;
  })

  const showModal = ref(false); 
  
  const showSearchBox = reactive({
      'adder':false,
      'verifier': false,
      'viewer': false
  })

  function close_seach_fn(){
        showSearchBox.adder = false
        showSearchBox.verifier = false
        showSearchBox.viewer = false
  }

  const updaterResults = (selected_result, field_name)=>{
    if (field_name=="adder")  {
         form.adder_id= selected_result.id
         close_seach_fn()

         console.log('updaterResults: ',selected_result)
      
    } 
    if (field_name=="verifier") {
        form.verifier_id= selected_result.id
        close_seach_fn()

    }  
    if (field_name=="viewer") {
       form.viewer_id= selected_result.id
       close_seach_fn()
    }   


   
    console.log('selected_result: ',selected_result)
  }
//showToast('success','موفق شدید ')


watchEffect(() => {  
  console.log("Modal visibility:", showModal.value);  
}); 

const sendData = () => {
  //  console.log('form: ',form)
  // return ;
    
      form.post('/admin/item/save',{
            onError: (errors) => {
            
                  toast.error('An error occurred. Please try again.');
                  console.log('error: ',errors)
              
          },
            onSuccess:(response)=>{
          
              toast.success('عملیات جدید با موفقیت ساخته شد')
              form.clearErrors()
              
            }
        })
 };



const handleAdderNameChange =  _.debounce(()=>{
      axios.get(`/search/user/name?q=${form_search.adder_name}`).then(({data})=>{
        console.log('api success, data : ',data)
      }).catch(error=>{
         console.log('error in API. error: ',error)
      })
},500)

 
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
  </style>