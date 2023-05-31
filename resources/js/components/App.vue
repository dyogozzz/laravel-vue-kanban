<template>
    <Header></Header>
    <div class="board">
        <KanbanBoard :tasks="tasks"></KanbanBoard>
    </div>
</template>

<script>
import Header from "./Header.vue";
import KanbanBoard from "./KanbanBoard.vue";
import axios from "axios";
import Modal from "./Modal.vue";
import { ref } from "vue";

export default {
    setup() {
        const popupTriggers = ref({
            buttonTrigger: false,
        });

        const TogglePopup = (trigger) => {
            popupTriggers.value[trigger] = !popupTriggers.value[trigger];
        };

        return {
            Modal,
            popupTriggers,
            TogglePopup,
        };
    },
    name: "App",
    components: {
        Header,
        KanbanBoard,
        Modal,
    },
    mounted() {
        this.fetchTasks();
    },
    data() {
        return {
            tasks: [],
        };
    },
    methods: {
        fetchTasks() {
            axios
                .get("/tasks")
                .then((response) => {
                    this.tasks = response.data.map((task) => ({
                        ...task,
                        column: task.status,
                    }));
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>
