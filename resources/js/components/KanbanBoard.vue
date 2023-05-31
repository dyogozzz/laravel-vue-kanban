<template>
    <div class="kanban">
        <div
            class="column"
            :key="status"
            v-for="status in statusList"
            :data-column-id="status"
        >
            <button class="btn" @click="startOrdering">&darr;</button>
            <h2 class="lane-title">{{ status }}</h2>
            <div class="cards-container">
                <Draggable
                    :is-ordering="isOrdering"
                    :tasks="tasks"
                    @update:list="updateSortedTasks(status, $event)"
                    :list="getTasksByStatus(status)"
                    ref="draggable"
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
                            <div id="card-info">
                                <h2>{{ task.title }}</h2>
                                <p>Descrição da task:</p>
                                <div>{{ task.description }}</div>
                                <br />
                                <p>Usuário responsável:</p>
                                <div>{{ task.usuario }}</div>
                                <br />
                                <p>vencimento da task: {{ task.vencimento }}</p>
                                <button @click="openModalEdit(task)">
                                    Editar task
                                </button>
                                <button @click="ExcludeTask(task.id)">
                                    Apagar task
                                </button>
                                <Modal
                                    :isOpen="editTask.isOpen"
                                    @close="closeModalEdit"
                                >
                                    <Edit
                                        v-if="editTask.isOpen"
                                        :taskId="task.id"
                                    ></Edit>
                                </Modal>
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
import Edit from "./Edit.vue";

export default defineComponent({
    watch: {
        statusList: {
            handler() {
                this.updateDraggableLists();
            },
            deep: true,
        },
    },
    components: {
        Draggable,
        Card,
        Modal,
        Edit,
    },
    data() {
        return {
            statusList: [
                "Backlog",
                "Pendente",
                "Em andamento",
                "Concluído",
                "Em correção",
            ],
            tasks: [],
            sortedTasks: {},
            isOrdering: false,
            editTask: {
                isOpen: false,
            },
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

        ExcludeTask(id) {
            axios.delete(`/delete/task/${id}`);

            window.location.reload();
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

            // Atualize as tasks da coluna
            this.sortedTasks[column] = sortedTasksByDueDate;

            // Emita o evento de atualização para o componente Draggable
            this.$refs.draggable.updateList(column, sortedTasksByDueDate);
        },

        toggleSorting() {
            this.enableSorting = !this.enableSorting;
        },

        flattenTasks() {
            return this.statusList.flatMap(
                (status) => this.sortedTasks[status]
            );
        },

        updateSortedTasks(status, updatedList) {
            this.sortedTasks[status] = updatedList;
        },

        startOrdering() {
            this.$emit("update:is-ordering", true);
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

        openModalEdit() {
            this.editTask.isOpen = true;
        },

        closeModalEdit() {
            this.editTask.isOpen = false;
        },
    },
    mounted() {
        this.fetchTasks();
    },
});
</script>

<style>
#card-info {
    font-size: 20px;
}

.kanban {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    margin: 1.2rem 0.8rem;
    align-items: flex-start;
}

.column {
    background: #e0e0e0;
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
    margin-bottom: 20px;
    max-width: 35rem;
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

@media (max-width: 800px) {
    .column {
        width: 20rem;
        min-width: 28rem;
        max-width: 28rem;
    }
}
</style>
