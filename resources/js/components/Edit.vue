<template>
    <div id="form-container">
        <h2>Editar task</h2>
        <form @submit.prevent="editTask">
            <div>
                <label for="title">Título:</label>
                <input type="text" id="title" v-model="Task.title" required />
            </div>
            <div>
                <label for="description">Descrição:</label>
                <textarea
                    id="description"
                    v-model="Task.description"
                ></textarea>
            </div>
            <div>
                <label for="vencimento">Vencimento:</label>
                <input type="date" id="vencimento" v-model="Task.vencimento" />
            </div>
            <div>
                <label for="prioridade">Prioridade:</label>
                <br />
                <select id="prioridade" v-model="Task.prioridade">
                    <option value="c">Baixa</option>
                    <option value="b">Média</option>
                    <option value="a">Alta</option>
                </select>
            </div>
            <div>
                <label for="usuario">Usuário:</label>
                <br />
                <select id="usuario" v-model="Task.usuario">
                    <option
                        v-for="user in users"
                        :value="user.id"
                        :key="user.id"
                    >
                        {{ user.name }}
                    </option>
                </select>
            </div>
            <button class="btn-create" type="submit">Editar</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: {
        taskId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            Task: {
                title: "",
                description: "",
                status: "Backlog",
                prioridade: "",
                vencimento: "",
                usuario: "",
            },
            users: [],
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers() {
            axios
                .get("/users")
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        editTask() {
            axios
                .put(`/edit/body/task/${this.taskId}`, this.Task)
                .then(() => {
                    this.Task = {
                        title: "",
                        description: "",
                        prioridade: "",
                        vencimento: "",
                        usuario: "",
                    };

                    window.location.reload();
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
};
</script>

<style scoped>
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
.btn-create {
    display: flex;
    align-items: center;
}

.btn-create button {
    border: none;
    background-color: #6c63ff;
    padding: 0.4rem 1rem;
    border-radius: 5px;
    cursor: pointer;
}

.btn-create button:hover {
    background-color: #6b63fff1;
}

.btn-create button a {
    text-decoration: none;
    font-weight: 500;
    color: #fff;
}

#title {
    font-size: 2rem;
}

#description {
    font-size: 2rem;
    min-height: 20rem;
}

#vencimento {
    height: 3rem;
    font-size: 16px;
}

#usuario {
    width: 100%;
    height: 3rem;
    font-size: 2rem;
}

#prioridade {
    width: 100%;
    height: 3rem;
    font-size: 2rem;
}

#form-container {
    width: 50rem;
    height: 50rem;
    font-size: 20px;
}

h2 {
    margin-bottom: 1rem;
}

form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

label {
    font-weight: bold;
}

input[type="text"],
textarea,
input[type="date"] {
    width: 100%;
}

@media screen and (max-width: 1330px) {
    .form-image {
        display: none;
    }
    .container {
        width: 50%;
    }
    .form {
        width: 100%;
    }
}

@media screen and (max-width: 1064px) {
    #form-container {
        width: 90%;
        height: auto;
    }
}
</style>
