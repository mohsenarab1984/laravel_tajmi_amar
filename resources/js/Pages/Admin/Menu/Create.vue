<template>
  <h3>
    ساخت منو
  </h3>
    <div>
            <div class="mb-3">
                <label for="title" class="form-label"> عنوان منو </label>
                <input type="text" class="form-control" id="title" v-model="form.title">
                <div v-if="form.errors.title" class="color_red">{{ form.errors.title }}</div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">منوی والد</label>
                 <select v-model="form.parent_id">
                     <option value="0"> ندارد </option>
                  
                     <option :value="menu.id" v-for="menu in menus">  {{ menu.title }} </option>
                   
                 </select>
                <div v-if="form.errors.parent_id" class="color_red">{{ form.errors.parent_id }}</div>
            </div>

            <button class="btn btn-primary" @click="sendData" :disabled="form.processing">create</button>

    </div>

      
  </template>
  
  <script setup>
  import { ref } from 'vue';

  import { useForm } from '@inertiajs/vue3';

  import { toast } from 'vue3-toastify'
  import 'vue3-toastify/dist/index.css';
  const props = defineProps(['menus']);

//showToast('success','موفق شدید ')

  
  const title = ref('');
  const selectedFile = ref(null);

  const form = useForm({
    title:'',
    parent_id:''
  })
  
 
  
  const sendData = () => {

    console.log(form)
    //return ;
     form.post('/admin/menu/save',{
      preserveScroll: true,
      onSuccess:()=>{
        form.reset()
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