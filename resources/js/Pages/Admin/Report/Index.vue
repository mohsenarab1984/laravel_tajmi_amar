<template>
<div class="p-3 m-3" v-for="item in items" style="border: 1px solid #999;">
      <ItemFill :item="item" />
</div>
</template>
<script setup>
const props = defineProps(['items','user_id'])
import ItemFill from "@Components/ItemFill.vue";
 
import { usePage } from "@inertiajs/vue3";
console.log('items: ',props.items)
console.log('prop[s]: ',props.user_id)

const page = usePage();

console.log("page.props.user [pages/Admin/Report/Index.vue]: ", page.props.auth.user);

</script>
<style scoped>


    
</style>