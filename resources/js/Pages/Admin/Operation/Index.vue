<template>

    <div class="container mt-5">  
        <h2>Operations Table</h2>  
        <table class="table table-bordered">  
        <thead>  
            <tr>  
            <th style="width: 100px;">Row Number</th>  
            <th>Title</th>  
            <th>Description</th>  
            <th>Date</th>  
            </tr>  
        </thead>  
        <tbody>  
            <tr v-for="(operation, index) in operations" :key="index">  
            <td>{{ index + 1 }}</td>  
            <td> <Link href="/Admin/Operations/${}">  {{ operation.title }} </Link>  </td>  
            <td> <Link :href="`/operation/${operation.id}/show`">  مشاهده </Link>  </td>  
            <td>{{ operation.date }}</td>  
            </tr>  
        </tbody>  
        </table>  
    </div>  


</template>
<script setup>
const props = defineProps(['operations'])

console.log('operations: ', props.operations)
</script>

<style scoped>
.table {  
  table-layout: auto; /* Allows the table to size based on content */  
  max-width: 1000px;
  /*width: auto; /* Optional: lets the table width be determined by its contents */  
   
}  

th, td {  
  white-space: nowrap; /* Prevents text from wrapping */  
  vertical-align: middle; /* Aligns content vertically to the center */  
   
}  
</style>