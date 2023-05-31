<template>
    <div class="navbar">
        <a href="/profile">Dashboard</a>
        <a href="#" @click="openCreateModal">Criar Task</a>
        <Modal :is-open="isCreateModalOpen" @close="closeCreateModal">
            <Create />
        </Modal>

        <div class="dropdown">
            <button class="drop-btn">Exemplo</button>

            <div class="dropdown-content">
                <a href="#home">link 1</a>
                <a href="#home">Link 2</a>
                <a href="#home">Link 3</a>
            </div>
        </div>

        <div class="dropdown">
            <button class="drop-btn">Outro exemplo</button>

            <div class="dropdown-content">
                <a href="#home">link 1</a>
                <a href="#home">Link 2</a>
                <a href="#home">Link 3</a>
            </div>
        </div>
    </div>
    <br />
</template>

<script>
import Modal from "./Modal.vue";
import Create from "./Create.vue";

export default {
    components: {
        Modal,
        Create,
    },
    data() {
        return {
            isCreateModalOpen: false,
        };
    },
    methods: {
        openCreateModal() {
            this.isCreateModalOpen = true;
        },
        closeCreateModal() {
            this.isCreateModalOpen = false;
        },
    },
};
</script>

<style>
.navbar {
    overflow: hidden;
    background-color: #333;
    height: 4.6rem;
}

.navbar a {
    float: left;
    font-size: 16px;
    color: white;
    text-align: center;
    text-decoration: none;
    padding: 14px 16px;
}

.dropdown {
    float: left;
    overflow: hidden;
}

.dropdown .drop-btn {
    font-size: 16px;
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    margin: 0;
}

.navbar a:hover,
.dropdown:hover .drop-btn {
    background-color: red;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 150px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
