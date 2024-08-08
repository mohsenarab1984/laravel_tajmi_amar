<template>
   <div class="close_icon_class" :style="{'z-index':z_index ?? 1,'background-color': bg ?? '#bf1414'}" @click="emits('on_close')" > X</div>
</template>
<script setup>
    const props = defineProps(['z_index','bg'])
    const emits= defineEmits(['on_close'])
</script>
<style scoped>

.close_icon_class{
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