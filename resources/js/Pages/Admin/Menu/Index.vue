<template>
    <div>
        
    </div>
    <div>
            <div class="mb-3">
                <label for="title" class="form-label">عنوان</label>
                <input type="text" class="form-control" id="title" v-model="form.title">
                <div v-if="form.errors.title" class="color_red">{{ form.errors.title }}</div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">نوع</label>
                 <select v-model="form.type">
                     <option value="number"> عددی </option>
                     <option value="tick"> تیک </option>
                 </select>
                <div v-if="form.errors.type" class="color_red">{{ form.errors.type }}</div>
            </div>

            <button class="btn btn-primary" @click="sendData">Send</button>

    </div>

      
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  import { toast } from 'vue3-toastify'
  import 'vue3-toastify/dist/index.css';

//showToast('success','موفق شدید ')

  
  const title = ref('');
  const selectedFile = ref(null);

  const form = useForm({
    title:'',
    type:''
  })
  
  const onFileChange = (e) => {
    selectedFile.value = e.target.files[0];
  };
  
  const sendData = () => {
    
     form.post('/user/upload',{
      onSuccess:()=>{
        toast.success('عملیات با موفقیت انجام شد')
       // alert('موفق')
      }
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
  </style>