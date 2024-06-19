<template>
  <div>
    <div class="title">
      <h1>Desenvolvedores</h1>
      <button @click="showCreateModal">Adicionar Desenvolvedor</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Sexo</th>
          <th>Data de Nascimento</th>
          <th>Idade</th>
          <th>Hobby</th>
          <th>Nível</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="desenvolvedor in desenvolvedores" :key="desenvolvedor.id">
          <td>{{ desenvolvedor.id }}</td>
          <td>{{ desenvolvedor.nome }}</td>
          <td>{{ desenvolvedor.sexo }}</td>
          <td>{{ desenvolvedor.data_nascimento }}</td>
          <td>{{ desenvolvedor.idade }}</td>
          <td>{{ desenvolvedor.hobby }}</td>
          <td>{{ desenvolvedor.nivel.nivel }}</td>
          <td>
            <button @click="showEditModal(desenvolvedor)">Editar</button>
            <button @click="deleteDesenvolvedor(desenvolvedor.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <ModalDesenvolvedores v-if="isModalVisible" :desenvolvedor="selectedDesenvolvedor" @close="closeModal"
      @save="fetchDesenvolvedores" />
  </div>
</template>

<script>
import apiClient from "@/api"
import ModalDesenvolvedores from "@/components/ModalDesenvolvedores";
import { useToast } from 'vue-toast-notification';
const toast = useToast();

export default {
  components: {
    ModalDesenvolvedores,
  },
  data() {
    return {
      desenvolvedores: [],
      isModalVisible: false,
      selectedDesenvolvedor: null,
    }
  },
  created() {
    this.fetchDesenvolvedores()
  },
  methods: {
    fetchDesenvolvedores() {
      apiClient.get('/desenvolvedores')
        .then(response => {
          this.desenvolvedores = response.data
        })
        .catch(error => {
          this.desenvolvedores = []
          console.error(error)
        })
    },
    deleteDesenvolvedor(id) {
      if (confirm('Tem certeza que deseja excluir este desenvolvedor?')) {
        apiClient.delete(`/desenvolvedores/${id}`)
          .then(response => {
            const { status } = response
            toast.success(`Status: ${status}. Foi possivel excluir o desenvoveldor`)
            this.fetchDesenvolvedores()
          })
          .catch(error => {
            console.error(error)
          })
      }
    },
    showCreateModal() {
      this.selectedDesenvolvedor = null;
      this.isModalVisible = true;
    },
    showEditModal(desenvolvedor) {
      this.selectedDesenvolvedor = desenvolvedor;
      this.isModalVisible = true;
    },
    // Add a method to close the modal
    closeModal() {
      this.isModalVisible = false;
    },
  }
}
</script>
<style>
table {
  border-collapse: collapse;
  width: 100%;
  table-layout: auto !important;
  word-wrap: break-word;
}

td {
  padding: 24px;
  text-align: center;
  border-bottom: 1px solid rgb(224, 242, 237);
}

.header-item {
  padding: 30px 20px;
  font-size: 12px;
  background-color: rgb(224, 242, 237);
  text-transform: uppercase;
}

.table-rows:nth-child(odd) {
  background-color: rgb(250, 250, 250);
}

.table-rows:nth-child(n):hover {
  background-color: rgb(244, 246, 245);
}
</style>