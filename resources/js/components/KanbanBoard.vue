<template>
    <div class="kanban">
        <div
            class="column"
            :key="status"
            v-for="status in statusList"
            :data-column-id="status"
        >
            <button class="btn" @click="getColumn">&darr;</button>
            <h2 class="lane-title">{{ status }}</h2>
            <div class="cards-container">
                <Draggable
                    @update:list="updateSortedTasks(status, $event)"
                    :list="getTasksByStatus(status)"
                >
                    <div
                        v-for="task in getTasksByStatus(status)"
                        :key="task.id"
                        :data-item-id="task.id"
                    >
                        <Card
                            @click="openModal(task)"
                            :task="task"
                            :key="task.id"
                            :data-item-id="task.id"
                            :column="column"
                            >{{ task.title }}</Card
                        >
                        <Modal
                            :task="task"
                            :isOpen="task.isOpen"
                            @close="closeModal(task)"
                        >
                            <div>
                                <h2>{{ task.title }}</h2>
                                <p>{{ task.description }}</p>
                                <p>{{ task.usuario }}</p>
                                <p>{{ task.vencimento }}</p>
                            </div>
                        </Modal>
                    </div>
                </Draggable>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import Card from "./Card.vue";
import Draggable from "./Draggable.vue";
import axios from "axios";
import Modal from "./Modal.vue";

export default defineComponent({
    components: {
        Draggable,
        Card,
        Modal,
    },
    data() {
        return {
            statusList: ["Backlog", "Pendente", "Em andamento", "Concluído"],
            tasks: [],
            sortedTasks: {},
        };
    },
    methods: {
        fetchTasks() {
            axios
                .get("/tasks")
                .then((response) => {
                    this.tasks = response.data;
                    this.sortTasksByStatus();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getTasksByStatus(status) {
            return this.sortedTasks[status] || [];
        },
        sortTasksByStatus() {
            this.statusList.forEach((status) => {
                const tasksByStatus = this.tasks.filter(
                    (task) => task.status === status
                );
                this.sortedTasks[status] = tasksByStatus;
            });
        },
        orderByVencimento(a, b) {
            var dataA = new Date(a.vencimento);
            var dataB = new Date(b.vencimento);
            return dataA - dataB;
        },
        getColumn(event) {
            const column = this.getColumnStatus(event.target);
            const sortedTasks = [...this.sortedTasks[column]];
            const sortedTasksByDueDate = sortedTasks.sort(
                this.orderByVencimento
            );

            // const columnElement = event.target.closest(".column");
            // const cardsContainer =
            //     columnElement.querySelector(".cards-container");

            // // Remover todos os cards existentes
            // while (cardsContainer.firstChild) {
            //     cardsContainer.removeChild(cardsContainer.firstChild);
            // }

            // sortedTasksByDueDate.forEach((task) => {
            //     const cardElement = document.createElement("div");
            //     cardElement.classList.add("card");
            //     cardElement.textContent = task.title;

            //     // Adicione qualquer lógica adicional para estilizar o card ou adicionar classes, etc.

            //     cardsContainer.appendChild(cardElement);
            // });
        },
        updateSortedTasks(status, updatedList) {
            this.sortedTasks[status] = updatedList;
        },

        getColumnStatus(element) {
            const columnElement = element.closest(".column");
            if (columnElement) {
                const laneTitleElement =
                    columnElement.querySelector(".lane-title");
                if (laneTitleElement) {
                    return laneTitleElement.textContent;
                }
            }
            return null;
        },
        openModal(task) {
            task.isOpen = true;
        },
        closeModal(task) {
            task.isOpen = false;
        },
    },
    mounted() {
        this.fetchTasks();
    },
});
</script>

<style>
.kanban {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    margin: 1.2rem 0.8rem;
    align-items: flex-start;
}

.column {
    background: var(--color-grey);
    width: 23rem;
    min-height: 35rem;
    border-radius: 0.8rem;
    box-shadow: 0 0.1rem 0.2rem 0 rgba(33, 33, 33, 0.1);
    margin: 0 0.8rem;
    padding: 0 0.7rem;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    flex-grow: 1;
}

.lane-title {
    padding: 0.8rem 0.5rem;
    margin-bottom: 0.6rem;
    font-size: 30px;
}

.btn {
    padding: 0.8rem 0.5rem;
    margin-bottom: 0.6rem;
    display: flex;
    align-content: right;
}
</style>
