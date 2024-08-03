<template>
    <div class="mx-5" v-show="show">

         

            <div >

                <!-- <Item  v-for="item in items " :item="{...item}" style="background: #def1d9;" /> -->
                <ItemFill  v-for="item in items " :item="{...item}" style="background: #def1d9;" />
            </div>
       
        
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Item from './Item.vue';
import ItemFill from './ItemFill.vue';


const props = defineProps({
    items: Array,
    parent_menu: Object,
    show:Boolean
})

function toggleShowSubItems(){
    showSubItems.value = !showSubItems.value
    console.log('click')
}

const showSubItems = ref(false)
    
</script>
<style scoped>
  .span_icon {
    font-weight: bold;
    display: inline-block;
    margin: 2px 5px;
    cursor: pointer;
    width: 10px;
     
  }  
</style>