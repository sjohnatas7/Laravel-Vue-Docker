<template>
  <div>
    <div class="title">
      <h1>Níveis</h1>
      <button @click="showCreateModal">Adicionar Nível</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nível</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="nivel in niveis" :key="nivel.id">
          <td>{{ nivel.id }}</td>
          <td>{{ nivel.nivel }}</td>
          <td>
            <button @click="showEditModal(nivel)">Editar</button>
            <button @click="deleteNivel(nivel.id)">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>
    <ModalNivel v-if="isModalVisible" :nivel="selectedNivel" @close="closeModal" @save="fetchNiveis" />
  </div>
</template>

<script>
import apiClient from "@/api";
import ModalNivel from "@/components/ModalNivel";
import { useToast } from 'vue-toast-notification';
const toast = useToast();

export default {
  components: {
    ModalNivel,
  },
  data() {
    return {
      niveis: [],
      isModalVisible: false,
      selectedNivel: null,
    };
  },
  created() {
    this.fetchNiveis();
  },
  methods: {
    fetchNiveis() {
      apiClient
        .get("/niveis")
        .then((response) => {
          this.niveis = response.data;
        })
        .catch((error) => {
          this.niveis = []
          console.error(error);
        });
    },
    showCreateModal() {
      this.selectedNivel = null;
      this.isModalVisible = true;
    },
    showEditModal(nivel) {
      this.selectedNivel = nivel;
      this.isModalVisible = true;
    },
    deleteNivel(id) {
      if (confirm("Tem certeza que deseja excluir este nível?")) {
        apiClient
          .delete(`/niveis/${id}`)
          .then((response) => {
            const { status } = response
            toast.success(`Status: ${status}. Foi possível excluir usuario`)
            this.fetchNiveis();
          })
          .catch((error) => {
            console.error(error);
          });
      }
    },
    closeModal() {
      this.isModalVisible = false;
    },
  },
};
</script>

<style>
.title {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.title button {
  height: 100%;
  padding: 10px;
}
</style>
