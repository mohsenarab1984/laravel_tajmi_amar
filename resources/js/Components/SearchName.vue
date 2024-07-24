<template>
<div style="" :class="{'black-bg-show':showSearchBox}">

    <div id="inner" style="position: relative;">

            <div class="close_icon" @click="btn_close_click" v-if="showSearchBox">
                X
            </div>
    
            <div style="display: inline-block" class="mx-2">      <i class="fas fa-search" @click="openSearch"></i>      </div>
            <div style="display: inline-block" class="mx-2">{{selected_name }}</div>
            <div style="position: absolute; right: 0;">
    
                    <div id="search_results" v-if="showSearchBox" style="position: relative; display: inline-block; width: 400px; margin: 0 50px;  max-height: 400px;" >
                        <input type="text" v-model="name" @input="handleAdderNameChange" class="form-control d-inline-block" style="max-width:400px ;" placeholder="جستجوی نام"> 
                     
                        <ul v-if="results.length && !error" class="search_resuls" style="position: absolute; top: 25px; left: 0; width: 400px;">
                            <li v-for="result_row in results" class="result_row" @click="selectResultfunction(result_row)">{{ result_row.name }}</li>
                        </ul>
                        <ul v-else class="search_resuls">
                            <li v-if="search_end" > نتیجه ای یافت نشد </li>
                        </ul>
                        
                    </div>
            </div>
    
      
    </div>
</div>
</template>
<script setup>
import { ref, watchEffect } from 'vue';
import _ from 'lodash'
import axios from 'axios'

import '@fortawesome/fontawesome-free/css/all.min.css';  

const props = defineProps(['show'])

const name= ref(null)
const selected_name= ref(null)
const results= ref([])
const search_end= ref(false)
const error= ref(null)
const error_text= ref(null)

const showSearchBox = ref(true)
watchEffect(()=>{
     showSearchBox.value = props.show
})

function openSearch(){
    emit('clickSearchIcon',true)
}

const emit = defineEmits(['selectRowEmit','clickSearchIcon','close_search'])

function selectResultfunction(row){
      emit('selectRowEmit',row)
      selected_name.value = row.name
}

function btn_close_click(){
    emit('close_search')
}

const handleAdderNameChange =  _.debounce(()=>{
       error.value=null
       search_end.value=false
      axios.get(`/search/user/name?q=${name.value}`).then(({data})=>{
        console.log('api success, data : ',data)
        results.value = data.results
      }).catch(error=>{
         error.value=true
         error_text.value = error
         console.log('error in API. error: ',error)
        }).finally(()=>{
          search_end.value=true

         })
},500)
    
</script>

<style scoped>
.search_resuls{
    max-width: 400px;
    background: #f8f8f8;
    text-align: center;
    font-weight: bold;
    border:1px solid #ccc;
}
.search_resuls .result_row:hover{
   background-color: #bbb;
}

.black-bg-show{
    width: 500px;
    height: 300px;
    background-color: black;
    opacity: 0.5;

}

.close_icon{
    justify-content: center;
    position: absolute;
    display: flex;
    top: -7px;
    left: -5px;
    width: 20px;
    height: 20px;
    border-radius: 100%;
    background-color: #bf1414;
    color: rgb(255, 255, 255);
    align-items: center;
    cursor: pointer;
}
</style>