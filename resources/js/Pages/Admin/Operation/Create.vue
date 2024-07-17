<template>
    <h3>
      ساخت عملیات
    </h3>
      <div>
              <div class="mb-3">
                  <label for="title" class="form-label">عنوان عملیات</label>
                  <input type="text" class="form-control" id="title" v-model="form_operation.title">
                  <button class="btn btn-primary " @click="operation_create" > ذخیره </button>
                  <div v-if="form_operation.errors.title" class="color_red">{{ form_operation.errors.title }}</div>
              </div>
  
             
            
             
  
      </div>
  
        
    </template>
    
    <script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import _ from 'lodash'
    import axios from 'axios'
  
    import { toast } from 'vue3-toastify'
    import 'vue3-toastify/dist/index.css';

    const form_operation = useForm({
         title:'',
         operation_id: null
          
   })
  
    const operation_create = () => {
      
      form_operation.post('/admin/operation/create',{
            onError: (errors) => {
              // Handle any validation errors from the backend response
              // You can display these errors to the user
              //console.error(errors);
              if (errors.title) {
                  //.error(errors.title);
              } else {
                  toast.error('An error occurred. Please try again.');
              }
          },
            // onSuccess:(response)=>{
            //   ///const operationId = response.data.id;
            //   const operationId = response.props.operationId;
            //   form_operation.operation_id = operationId
            //   console.log('response.props.operationId: ',response.props.operationId)
            //   toast.success('عملیات جدید با موفقیت ساخته شد')
            //   form_operation.clearErrors()
            //   // alert('موفق')
            // }
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
    </style>