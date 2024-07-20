<template>
      <template v-for="menu in this_menu__sumneus">
             <Menu_Components  :menu="menu" :operation="operation" :menus="menus" />
      </template>
</template>
<script setup>

import { ref, watchEffect } from 'vue';
import Create_Menu_Component from './Create_Menu_Component.vue';
import Menu_Components from './Menu_Components.vue';


const props = defineProps(['menus','operation','parent_menu'])
const this_menu__sumneus = ref([])

watchEffect(()=>{
    this_menu__sumneus.value = props.menus.filter(m=>m.parent_id ==  (props.parent_menu?.id ?? 0))
    // console.log('@@@@: ', props.menus.filter(m=>m.parent_id ==  props.parent_menu?.id ))
})

</script>