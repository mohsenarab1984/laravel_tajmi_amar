<template>
    <form @submit.prevent="submitForm">
      <div   style="max-width: 300px; margin: 0 auto" class="text-center">
                   <div class="row my-2">

                    <input type="text" v-model="myForm.username" placeholder="Username" class="p-2">
                  </div>
                  <div class="row my-2">

                    <input type="password" v-model="myForm.password" placeholder="Password" class="p-2">
                  </div>
                  <div class="row">

                    <button type="submit" class="btn btn-primary">Login</button>
                  </div>
                  <!-- <div v-if="errors.length">
                    <ul>
                      <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                  </div> -->

      </div>

      <div>
        {{ errors }}
      </div>
      
    </form>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm, router } from '@inertiajs/vue3';
  defineProps(['errors'])
  
  const form = {
    username: '',
    password: ''
  };
  
  // const { data, setData, post, errors } = useForm(form);
  const myForm = useForm(form);
  
  const submitForm = () => {
    // console.log('fdfd')
    myForm.post('/login',{
      preserveScroll: true,
      // onSuccess: () => {router.get('/')},
}    );
  };
  </script>