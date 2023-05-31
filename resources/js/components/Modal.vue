<template>
    <div class="modal" v-if="isOpen">
        <div class="popup-inner">
            <slot></slot>
            <button @click="closeModal" class="popup-close">X</button>
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
            this.$emit("close");
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
    background: #f1f1f1;
    padding: 32px;
    border-radius: 15px;
    position: relative;
    min-height: 50rem;
    min-width: 50rem;
    max-width: 90vw;
}

.modal-content {
    background-color: #fff;
    border-radius: 4px;
    padding: 20px;
    max-width: 600px;
    width: 80%;
}

.popup-close {
    position: absolute;
    top: 15px;
    right: 15px;
    border-color: #333;
    padding: 5px;
    font-weight: bold;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease-out;
    width: 25px;
}

.popup-close:hover {
    background-color: rgb(223, 18, 18);
    color: white;
}

@media (max-width: 800px) {
    .popup-inner {
        min-height: 20rem;
        min-width: 20rem;
    }
}
</style>
