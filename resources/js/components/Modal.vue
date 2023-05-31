<template>
    <div class="modal" v-if="isOpen">
      <div class="popup-inner">
        <slot></slot>
        <button @click="closeModal" class="popup-close">Fechar</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      isOpen: {
        type: Boolean,
        required: true,
      },
    },
    methods: {
      closeModal() {
        this.$emit('close');
      },
    },
  };
  </script>
  
  <style scoped>
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 99;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .popup-inner {
    background: #fff;
    padding: 32px;
    border-radius: 15px;
  }
  
  .modal-content {
    background-color: white;
    border-radius: 4px;
    padding: 20px;
    max-width: 600px;
    width: 80%;
  }
  </style>
  