<template>
    <div class="card">
      <slot></slot>
    </div>
  </template>

<script>
import Modal from './Modal.vue'
export default {
    props: {
        column: {
            type: String,
            required: true,
        },
        task: {
            type: Object,
            required: true,
        },
    },
    name: "Card",
    components: {
        Modal,
    },
};
</script>

<style scoped>
.card {
    background: #fff;
    padding: 1.4rem;
    border-radius: 0.4rem;
    box-shadow: 0 1px 0 rgba(9, 30, 66, 0.25);
    font-size: 1.6rem;
    margin-bottom: 0.8rem;
    cursor: pointer;
}

.card:hover {
    background: #69bdf9;
    box-shadow: 0 1px 0 rgba(23, 77, 16, 0.25);

}
</style>
