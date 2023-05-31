<template>
    <div class="flex m-10">
        <draggable
            group="tarefas"
            class="dragArea list-group w-full"
            @change="log"
            itemKey="name"
            @end="onItemDropped"
        >
            <slot></slot>
        </draggable>
    </div>
</template>
<script>
import { defineComponent } from "vue";
import { VueDraggableNext } from "vue-draggable-next";
import axios from "axios";

export default defineComponent({
    watch: {
        isOrdering(newVal) {
            if (newVal) {
                this.orderTasks();
            }
        },
    },
    props: {
        tasks: {
            type: Array,
            required: true,
        },
        isOrdering: Boolean,
    },
    components: {
        draggable: VueDraggableNext,
    },
    data() {
        return {
            list: [],
        };
    },
    methods: {
        log(event) {
            console.log(event);
        },
        onItemDropped(event) {
            const newStatus = this.getColumnStatus(event.to);
            const itemId = event.item.getAttribute("data-item-id");

            axios.put(`/edit/task/${itemId}`, {
                status: newStatus,
            });

            this.$emit("update: list", this.list);
        },
        getColumnStatus(element) {
            const columnElement = element.closest(".column");
            console.log(element);
            if (columnElement) {
                const laneTitleElement =
                    columnElement.querySelector(".lane-title");
                if (laneTitleElement) {
                    return laneTitleElement.textContent;
                }
            }
            return null;
        },
        orderTasks() {
            const columnStatus = this.getColumnStatus(this.$el);
            if (columnStatus) {
                const sortedTasks = this.tasks.filter(
                    (task) => task.status === columnStatus
                );
                this.tasks = sortedTasks;
            }
        },

        updateTasks(newTasks) {
            this.tasks = newTasks;
        },
        startOrdering() {
            this.$emit("update:is-ordering", true);
        },
    },
});
</script>
