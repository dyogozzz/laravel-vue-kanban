<template>
    <div class="kanban">
        <div
            class="column"
            :key="status"
            v-for="status in statusList"
            :data-column-id="status"
        >
            <h2 class="lane-title">{{ status }}</h2>
            <div class="buttons-sort">
                <h3>Ordenar por:</h3>
                <button class="btn" id="btn-1" @click="getColumnPrio">
                    Prioridade
                </button>
                <button class="btn" id="btn-2" @click="getColumn">
                    Vencimento
                </button>
            </div>
            <div class="cards-container">
                <Draggable
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
                            <div class="card-info">
                                <h2 class="task-title">{{ task.title }}</h2>
                                <p class="task-description-title">Descrição:</p>
                                <div class="task-description">
                                    <p>
                                        {{ task.description }}
                                    </p>
                                </div>
                                <p class="task-user-name">
                                    Usuário responsável: {{ task.usuario }}
                                </p>
                                <br />
                                <p class="task-due">
                                    Data limite:
                                    {{ formatDate(task.vencimento) }}
                                </p>
                                <div class="div-button">
                                    <button
                                        class="button-modal"
                                        @click="openModalEdit(task)"
                                    >
                                        Editar task
                                    </button>
                                    <button
                                        class="button-modal"
                                        @click="ExcludeTask(task.id)"
                                    >
                                        Apagar task
                                    </button>
                                </div>
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
            sortedTasks: [],
            editTask: {
                isOpen: false,
            },
        };
    },
    methods: {
        fetchTasks() {
            axios
                .get("/api/tasks/all")
                .then((response) => {
                    this.tasks = response.data;
                    this.sortTasksByStatus();
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, "0");
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        },

        ExcludeTask(id) {
            axios.delete(`/api/delete/task/${id}`);

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

        orderByVencimentoReverse(a, b) {
            var dataA = new Date(a.vencimento);
            var dataB = new Date(b.vencimento);
            return dataB - dataA;
        },

        orderByPrioridade(a, b) {
            var prioridadeA = a.prioridade.toUpperCase();
            var prioridadeB = b.prioridade.toUpperCase();

            var prioridadeOrder = { A: 1, B: 2, C: 3 };

            if (prioridadeOrder[prioridadeA] < prioridadeOrder[prioridadeB]) {
                return -1;
            }
            if (prioridadeOrder[prioridadeA] > prioridadeOrder[prioridadeB]) {
                return 1;
            }

            return 0;
        },

        orderByPrioridadeReverse(a, b) {
            var prioridadeA = a.prioridade.toUpperCase();
            var prioridadeB = b.prioridade.toUpperCase();

            var prioridadeOrder = { A: 1, B: 2, C: 3 };

            if (prioridadeOrder[prioridadeA] < prioridadeOrder[prioridadeB]) {
                return 1;
            }
            if (prioridadeOrder[prioridadeA] > prioridadeOrder[prioridadeB]) {
                return -1;
            }

            return 0;
        },

        getColumnPrio(event) {
            const columnPrio = this.getColumnStatus(event.target);
            const sortedTasks = this.sortedTasks[columnPrio];

            let sortedTasksByPrio = sortedTasks.sort(
                this.orderByPrioridadeReverse
            );
            this.sortedTasks[columnPrio] = sortedTasksByPrio;

            setTimeout(() => {
                sortedTasksByPrio = sortedTasks.sort(this.orderByPrioridade);

                this.sortedTasks[columnPrio] = sortedTasksByPrio;
            }, 1);
        },

        getColumn(event) {
            const column = this.getColumnStatus(event.target);
            const sortedTasks = this.sortedTasks[column];

            let sortedTasksByDueDate = sortedTasks.sort(this.orderByVencimento);

            this.sortedTasks[column] = sortedTasksByDueDate;

            setTimeout(() => {
                sortedTasksByDueDate = sortedTasks.sort(
                    this.orderByVencimentoReverse
                );

                this.sortedTasks[column] = sortedTasksByDueDate;
            }, 1);
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

@media (max-width: 800px) {
    .column {
        width: 20rem;
        min-width: 28rem;
        max-width: 28rem;
    }
}

.card-info {
    font-size: 20px;
    min-width: 30rem;
    min-height: 30rem;
}

.div-button {
    display: flex;
    justify-content: center;
}

.button-modal {
    border-color: #333;
    color: #333;
    padding: 7px;
    margin: 0 5px;
    font-weight: bold;
    font-size: 12pt;
    margin-top: 20px;
    border-radius: 4px;
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease-out;
}

.button-modal:hover {
    background-color: rgb(206, 82, 20);
    color: white;
}

.task-title {
    color: #333;
    display: flex;
    justify-content: center;
}

.task-description-title {
    margin-top: 15px;
}

.task-description {
    max-width: 420px;
    margin-top: 15px;
    min-height: 200px;
    margin-bottom: 30px;
    font-size: 16px;
}

.buttons-sort {
    position: relative;
    height: 4rem;
}

.btn {
    border-color: #333;
    color: #333;
    padding: 7px;
    font-weight: bold;
    font-size: 8pt;
    border-radius: 4px;
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease-out;
}

#btn-1 {
    position: absolute;
    top: -10px;
    right: 0;
}

#btn-2 {
    position: absolute;
    top: -10px;
    right: 75px;
}

h3 {
    position: absolute;
    top: -5px;
    left: 7px;
    font-size: 16px;
}
</style>
