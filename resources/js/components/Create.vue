<template>
    <div id="form-container">
        <h2>Criar Nova Task</h2>
        <form @submit.prevent="createTask">
            <div>
                <label for="title">Título:</label>
                <input
                    type="text"
                    id="title"
                    v-model="newTask.title"
                    required
                />
            </div>
            <div>
                <label for="description">Descrição:</label>
                <textarea
                    id="description"
                    v-model="newTask.description"
                ></textarea>
            </div>
            <div>
                <label for="vencimento">Vencimento:</label>
                <input
                    type="date"
                    id="vencimento"
                    v-model="newTask.vencimento"
                />
            </div>
            <div>
                <label for="prioridade">Prioridade:</label>
                <br />
                <select id="prioridade" v-model="newTask.prioridade">
                    <option value="c">Baixa</option>
                    <option value="b">Média</option>
                    <option value="a">Alta</option>
                </select>
            </div>
            <div>
                <label for="usuario">Usuário:</label>
                <br />
                <select id="usuario" v-model="newTask.usuario">
                    <option
                        v-for="user in users"
                        :value="user.name"
                        :key="user.id"
                    >
                        {{ user.name }}
                    </option>
                </select>
            </div>
            <div class="btn-content">
                <button class="btn-create" type="submit">Criar</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            newTask: {
                title: "",
                description: "",
                status: "Backlog",
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
                .get("/api/users")
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        createTask() {
            axios
                .post("/api/create/task", this.newTask)
                .then((response) => {
                    this.newTask = {
                        title: "",
                        description: "",
                        status: "Backlog",
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
    border-color: #333;
    padding: 5px;
    font-weight: bold;
    font-size: 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease-out;
    width: 80px;
}

.btn-create:hover {
    background-color: rgb(206, 82, 20);
    color: white;
}

.btn-content {
    display: flex;
    justify-content: center;
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
