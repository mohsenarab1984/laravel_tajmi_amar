<template>
<div   :class="{'black-bg-show':showSearchBox}" style="z-index:9" >

    <div id="inner" style="position: relative;">

            <div class="close_icon" @click="btn_close_click" >
                X
            </div>
    
            <!-- <div style="display: inline-block" class="mx-2">      <i class="fas fa-search" @click="openSearch"></i>      </div> -->
            <!-- <div style="display: inline-block" class="mx-2">{{selected_name }}</div> -->
            <div style="position: absolute; right: 0;">

                
                <div style=" display: inline-block; width: 400px; margin: 0 50px;  max-height: 400px;">
                         <div v-if="showSearchBox"  class="d-flex justify-content-between">
                             <div class="d-inline-block px-3 btn_tab" @click="set_tab_search(1)" :class="{'tab_clicked':tab_old_is_selected}"> جستجوهای قبلی </div>
                             <div class="d-inline-block px-3 btn_tab" @click="set_tab_search(2)" :class="{'tab_clicked':tab_new_is_selected}"> جستجوی جدید</div>
                         </div>
                         <div v-if="tab_new_is_selected && showSearchBox">

                                <div  id="search_results" class="mt-3" v-if="showSearchBox "  style="position: relative;">
                                    <input type="text" v-model="name" @input="handleAdderNameChange" class="form-control d-inline-block" style="max-width:400px ;" placeholder="جستجوی نام"> 
                                
                                    <ul v-if="results.length && !error" class="search_resuls" style="position: absolute; top: 25px; left: 0; width: 400px;">
                                        <li v-for="result_row in results" class="result_row" @click="selectResultfunction(result_row)">{{ result_row.name }}</li>
                                    </ul>
                                    <ul v-else class="search_resuls">
                                        <li v-if="search_end" > نتیجه ای یافت نشد </li>
                                    </ul>
        
                                    
                                    
                                </div>

                         </div>

                         <div v-if="tab_old_is_selected && showSearchBox" style="background-color: aliceblue;" class="tab_content mt-3">
                               <ul class="">
                                  <li class="search_most_frequent_user" v-for="user_obj in most_frequent_names" @click="selectResultfunction(user_obj)" 
                                       style="cursor: pointer;  ">
                                        {{ user_obj.name }}
                                         
                                        
                                  </li>
                               </ul>

                               
                          </div>
                     </div>
            </div>
    
      
    </div>
</div>
</template>
<script setup>
import { computed, onMounted, ref, watchEffect } from 'vue';
import _ from 'lodash'
import axios from 'axios'

import '@fortawesome/fontawesome-free/css/all.min.css';  
import { MyErrorHandling } from '@helpers/manage_errors';

const props = defineProps(['show'])
 import { toast } from 'vue3-toastify'

const name= ref(null)
const selected_name= ref(null)
const results= ref([])
const search_end= ref(false)
const error= ref(null)
const error_text= ref(null)

const showSearchBox = ref(true)


const tab_search=ref(1)

const most_frequent_names=ref([])

const tab_old_is_selected=computed(()=>tab_search.value==1)
const tab_new_is_selected=computed(()=>tab_search.value==2)

function set_tab_search(val){
    tab_search.value =  val
   

    //console.log('tab_search.value: ',tab_search.value);
     
    
}

watchEffect(()=>{
     showSearchBox.value = props.show
     console.log('0517 showSearchBox.value: ',showSearchBox.value)
     if(most_frequent_names.value.length==0 && showSearchBox.value){
        seach_most_frequent_names()
        console.log('seach_most_frequent_names()');
    }
})

onMounted(()=>{
    

})

function  seach_most_frequent_names(){
       axios.get('/search/frequest').then(res=>{
            most_frequent_names.value = res.data.data
            console.log(res);
        }).catch(errorResponse=>{
                       const  {message, errors,...other}= MyErrorHandling(errorResponse)
                       if (message) toast(message)
                       //form.errors = errors
                       console.log(other)
        })

}

onMounted(()=>{
    if(showSearchBox){

        // axios.get('/search/frequest').then(res=>{
        //    console.log(res);
        // }).catch(errorResponse=>{
        //                const  {message, errors,...other}= MyErrorHandling(errorResponse)
        //                if (message) toast(message)
        //                //form.errors = errors
        //                console.log(other)
        // })
    }
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
    console.log('close_search');
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
    cursor: pointer;
}
.search_resuls .result_row:hover{
   background-color: #999;
   color: white;
}

.tab_content{
    max-width: 400px;
    background: #f8f8f8;
    text-align: center;
    font-weight: bold;
    border:1px solid #ccc;
}

.black-bg-show{
    width: 500px;
    height: 300px;
    background-color: rgb(83, 82, 82);
    /* opacity: 0.5; */

}



.btn_tab{
     cursor: pointer;
     border: 1px solid #999;
     padding: 1px;
     color: white;

}

.btn_tab:hover{
    background-color: #1d29d5;
    color: white;
    font-weight: bold;
}

.tab_clicked {
    background: #1d29d5;
    color: white;
}

.search_most_frequent_user:hover{
    background-color: #999;
    color: white;
}
</style>