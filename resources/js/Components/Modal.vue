<template>  
    <div v-if="isVisible" class="modal-overlay" @click.self="close">  
      <div class="modal">  
        <button class="close" @click="close">X</button>  
        <div>
            dfdfdfdfd
        </div>
        <slot></slot> <!-- Slot for modal content -->  
      </div>  
    </div>  
  </template>  
  
  <script setup>  
  import { defineProps, defineEmits } from 'vue';  
  
  const props = defineProps({  
    isVisible: {  
      type: Boolean,  
      required: true,  
    },  
  });  
  
  const emit = defineEmits();  
  
  const close = () => {  
    emit('update:isVisible', false); // Emit the event to update visibility  
  };  
  </script>  
  
  <style scoped>  
  .modal-overlay {  
    position: fixed;  
    top: 0;  
    left: 0;  
    width: 100%;  
    height: 100%;  
    background: rgba(0, 0, 0, 0.7); /* Semi-transparent black */  
    display: flex;  
    align-items: center;          /* Center the modal vertically */  
    justify-content: center;      /* Center the modal horizontally */  
  }  
  
  .modal {  
    background: white;            /* White background for the modal content */  
    padding: 20px;  
    border-radius: 5px;  
    max-width: 500px;  
    width: 90%;                   /* Responsive width */  
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */  
  }  
  
  .close {  
    background: none;  
    border: none;  
    font-size: 16px;  
    cursor: pointer;  
    position: absolute;  
    top: 10px;  
    right: 10px;  
  }  
  </style>