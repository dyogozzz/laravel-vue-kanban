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
    props: {
        tasks: {
            type: Array,
            required: true,
        },
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

            axios.put(`/api/edit/task/${itemId}`, {
                status: newStatus,
            });
            this.$emit("update: list", this.list);
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
    },
});
</script>
