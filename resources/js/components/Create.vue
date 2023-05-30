<template>
  <div id="form-container">
    <h2>Criar Nova Task</h2>
    <form @submit.prevent="createTask">
      <div>
        <label for="title">Título:</label>
        <input type="text" id="title" v-model="newTask.title" required />
      </div>
      <div>
        <label for="description">Descrição:</label>
        <textarea id="description" v-model="newTask.description"></textarea>
      </div>
      <div>
        <label for="vencimento">Vencimento:</label>
        <input type="date" id="vencimento" v-model="newTask.vencimento" />
      </div>
      <div>
        <label for="usuario">Usuário:</label>
        <br>
        <select id="usuario" v-model="newTask.usuario">
          <option v-for="user in users" :value="user.id" :key="user.id">
            {{ user.name }}
          </option>
        </select>
      </div>
      <button class="btn-create" type="submit">Criar</button>
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
    createTask() {
      axios
        .post("/create/task", this.newTask)
        .then((response) => {
          console.log("Tarefa criada:", this.newTask);
          this.newTask = {
            title: "",
            description: "",
            status: "Backlog",
            vencimento: "",
            usuario: "",
          };

          // Atualizar a lista de tarefas
          this.$emit("updateTasks");

          // Ou, se você quiser recarregar a página inteira
          // window.location.reload();
        })
        .catch((error) => {
          console.error(error);
        });
    },
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
