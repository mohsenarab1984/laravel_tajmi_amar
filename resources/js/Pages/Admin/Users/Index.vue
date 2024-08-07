<template>
 

 

<h1>

    Admin . users
</h1>

<div class="container mt-5">  
        <h2>Operations Table</h2>  
        <table class="table table-bordered">  
        <thead>  
            <tr>  
            <th style="width: 100px;">Row Number</th>  
            <th>name</th>  
            <th>username</th>  
            <th>نقش</th>  
            <th>Date</th>  
            </tr>  
        </thead>  
        <tbody>  
            <tr v-for="(user, index) in users" :key="index">  
            <td>{{ index + 1 }}</td>  
            <td> {{ user.name }}  </td>  
            <td>  {{ user.username }}  </td>  
            <td>  {{ user.role }}  </td>  
            
            </tr>  
        </tbody>  
        </table>  
    </div>  

</template>
<script setup>
// props = defineProps(['users'])
const props = defineProps(['users'])
console.log(props);
 

</script>