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

           

             <div>
                    <div class="mb-3 d-inline-block">
                      <div for="title" class="form-label ms-2 me-5" style="display: inline-block;">حداقل مقدار : </div>
                      <input type="text" class="form-control d-inline-block" id="min" v-model="form.min" style="width: 150px;">
                      
                      <div v-if="form.errors.min" class="color_red">{{ form.errors.min }}</div>
                  </div>

                  <div class="mb-3 d-inline-block">
                      <div for="title" class="form-label ms-2 me-5" style="display: inline-block;">حداکثر مقدار : </div>
                      <input type="text" class="form-control d-inline-block" id="min" v-model="form.max" style="width: 150px;">
                      
                      <div v-if="form.errors.max" class="color_red">{{ form.errors.max }}</div>
                  </div>
                  <!-- <div class="mx-2 mb-3 d-inline-block" :title="form.date_fa">
                    <div for="title" class="d-inline-block  ms-2 me-5" style="display: inline-block;">تاریخ مربوطه : </div>
                     <DatePicker v-model="form.date_fa" class="d-inline-block"></DatePicker>
                    
                  </div> -->

                   

               

             </div>

            <div class="mb-3  d-inline-block" style="position: relative;">
                <div for="title" class="form-label d-inline-block"  >نام  وارد کننده :  </div>
              
                <div style="display: inline-block" class="mx-2">      <i class="fas fa-search" @click="showSearchBox.adder=true"></i>      </div>
                <SearchName    :show="showSearchBox.adder" @close_search="close_seach_fn"  @selectRowEmit="(res)=>updaterResults(res,'adder')"
                   @clickSearchIcon="showSearchBox.adder=true"  class="d-inline-block" style="position: absolute; top:0; right: 0;" v-if="showSearchBox.adder" />  
                
                <div class="d-inline-block">{{ form.adder_name }}</div>  
                <div   class="color_red"  >{{ form.errors.adder_id   }}</div>
                <!-- <div   class="color_red" :style="{'opacity': form.errors.adder_id?.length>=1 ? 1: 0}">{{ form.errors.adder_id ?? '.' }}</div> -->
            </div>

            <div class="mb-3  d-inline-block me-5" style="position: relative;">
                <div for="title" class="form-label d-inline-block" >نام    تایید کننده :  </div>
               
                <div style="display: inline-block" class="mx-2">      <i class="fas fa-search" @click="showSearchBox.verifier=true"></i>      </div>
                <SearchName   :show="showSearchBox.verifier" @close_search="close_seach_fn"  @selectRowEmit="(res)=>updaterResults(res,'verifier')" @clickSearchIcon="showSearchBox.verifier=true" 
                   class="d-inline-block" style="position: absolute; top:0; right: 0;"   v-if="showSearchBox.verifier" />  
                
                <div class="d-inline-block">{{ form.verifier_name }}</div>
                   <div   class="color_red" >{{ form.errors.verifier_id }}</div>
                   <!-- <div   class="color_red" :style="{'opacity': form.errors.adder_id?.length>=1 ? 1: 0}">{{ form.errors.verifier_id ?? '.' }}</div> -->
            </div>

            <div class="mb-3  d-inline-block me-5" style="position: relative;">
                <div for="title" class="form-label d-inline-block" >نام    مشاهده کننده :  </div> 
               
                <div style="display: inline-block" class="mx-2">      <i class="fas fa-search" @click="showSearchBox.viewer=true"></i>      </div>
                <SearchName   :show="showSearchBox.viewer" @close_search="close_seach_fn"  @selectRowEmit="(res)=>updaterResults(res,'viewer')" @clickSearchIcon="showSearchBox.viewer=true" 
                   class="d-inline-block" style="position: absolute; top:0; right: 0;" v-if="showSearchBox.viewer"  />  

                <div class="d-inline-block" style="max-width: 400px; ">
                      <div v-for="viewer in form.viewer_arr " class="d-inline-block border mx-2 p-1" style="position: relative;">
                            {{ viewer.name }}
                            <!-- <div class="close_icon"   > X</div> -->
                              <closeButton bg="#999" @on_close="removeName(viewer.id)" />
                              
                      </div>
                </div>
                
                <div   class="color_red" >{{ form.errors.viewer_id }}</div>
            </div>

             
            <!-- <div v-if="form.errors">
                    <div v-for="error in form.errors" class="color_red"> {{ error }} </div>
            </div> -->
            <div class=" mt-2 mb-3 me-5" style="display: flex;  gap: 50px;">

              <button class="btn btn-success btn-sm " @click="sendData">ذخیره</button>
              <button class="btn btn-secondary btn-sm mx-3" @click="emit('toggle_show')">کنسل</button>
            </div>

    </div>

      
  </template>
  
  <script setup>
  import { onMounted, reactive, ref, watchEffect } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import _ from 'lodash'
  import axios from 'axios'

  import { toast } from 'vue3-toastify'
  import 'vue3-toastify/dist/index.css';

  import DatePicker from 'vue3-persian-datetime-picker'
  import moment from 'moment-jalaali';
  import {convertGregorianToPersian as date_en_to_persian, convertPersianToGregorian as date_fa_to_en} from '@js/helpers/convert_date'

//   import Modal from './Modal.vue';
import closeButton from './closeButton.vue';

const props = defineProps(['menu'])
const emit = defineEmits(['toggle_show'])


  import { Modal } from 'usemodal-vue3';
  import  ModalCustomized from './Modal.vue';
  import MyModal from './MyModal.vue';
  import SearchName from './SearchName.vue';
import { MyErrorHandling } from '../helpers/manage_errors';


const gregorianDate = ref('2022-03-21'); // Example Gregorian date (March 21, 2022)  
  
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
      adder_name:null,
      viewer_id:null,
      viewer_name:null,
      verifier_id: null,
      viewer_arr:[],
      menu_id: null,
      min: null,
      max: null,
      date_fa:null,
      date_en:null
})

  watchEffect(()=>{
    form.menu_id = props.menu?.id ;
    form.date_en = form.date_fa ? date_fa_to_en(form.date_fa) : '' 
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

  function removeName(id,role="viewer"){
    if(role == "viewer"){
      
      form.viewer_arr = form.viewer_arr.filter(v=>v.id !=id)
    }
  }

  const updaterResults = (selected_result, field_name)=>{
    if (field_name=="adder")  {
         form.adder_id= selected_result.id
         form.adder_name= selected_result.name
         close_seach_fn()

         console.log('updaterResults: ',selected_result)
      
    } 
    if (field_name=="verifier") {
        form.verifier_id= selected_result.id
        form.verifier_name= selected_result.name
        close_seach_fn()

    }  
    if (field_name=="viewer") {
       form.viewer_id= selected_result.id
       if(!form.viewer_arr.map(v=>v.id).includes(selected_result.id)){

         form.viewer_arr.push(selected_result)
       }else{
        console.log('تکراری است !!');
       }
       close_seach_fn()
    }   

          form.errors=""
          axios({
          method: "post",
          url: `/search/select/${selected_result.id}`,
          data: {
            username: "user",
            password: "pass",
          },
          }).then((response) => {
            console.log('json response:: ',response);
          }).catch(error=>{

                   const  {message, errors,...other}= MyErrorHandling(error)
                    if (message) toast(message)
                    form.errors = errors
                    console.log(other)
                       
                    //     if (error.response) {  
                    // // The request was made and the server responded with a status code  
                    //              if(error.response.status==422){
                    //                // validation error
                                   
                    //                toast.error(error.response.data.message || 'خطا در  اعتبارسنجی اطلاعات ورودی  ')
                    //                form.errors=Object.values(error.response.data?.errors).flat() 
                    //              }else{
                    //                toast.error(error.response.data.message || 'خطای نامشخص')
                    //              }
                    //         //.error('Error Status:', error.response.status);  
                    //         console.error('error.response.data', error.response.data,'error.response.status: ',error.response.status);  
                    //        // console.error('Error Message:', error.response.data.message || 'No specific message provided');  
                    //    } else if (error.request) {  
                    // // The request was made but no response was received  
                    //       console.error('No response received:', error.request);  
                    //       toast.error('خطایی اتفاق افتاده است')
                    //   } else {  
                    // // Something happened in setting up the request  
                    //         console.error('Error:', error.message);  
                    //         toast.error('خطایی اتفاق افتاده است')
                    //  }  
          });


   
    console.log('selected_result: ',selected_result)
  }
//showToast('success','موفق شدید ')


watchEffect(() => {  
  console.log("Modal visibility:", showModal.value);  
}); 

const sendData = () => {
  //  console.log('form: ',form)
  // return ;
    
      form.
        transform((data)=>({...data,viewer_arr:form.viewer_arr.map(v=>v.id)}))
        .post('/admin/item/save',{
            onError: (errors) => {
            
                  toast.error('An error occurred. Please try again.');
                  console.log('error: ',errors)
              
          },
            onSuccess:(response)=>{
          
              toast.success('عملیات جدید با موفقیت ساخته شد')
              form.clearErrors()
              form.reset()
              emit('toggle_show')
              
            },
            preserveScroll:true,
        }
      )
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

  .fa-search{
    cursor: pointer;
  }
  </style>