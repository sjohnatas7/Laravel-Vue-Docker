<template>
    <div class="modal">
      <div class="modal-content">
        <span class="close" @click="$emit('close')">&times;</span>
        <h2>{{ nivel ? "Editar Nível" : "Adicionar Nível" }}</h2>
        <input v-model="nivelName" placeholder="Digite o nome do nível" />
        <button @click="saveNivel">{{ nivel ? "Salvar" : "Adicionar" }}</button>
      </div>
    </div>
  </template>
  
  <script>
  import apiClient from "@/api";
  import { useToast } from 'vue-toast-notification';
  const toast = useToast();
  
  export default {
    props: {
      nivel: {
        type: Object,
        default: null,
      },
    },
    data() {
      return {
        nivelName: this.nivel ? this.nivel.nivel : "",
      };
    },
    methods: {
      saveNivel() {
        if (this.nivel) {
          apiClient
            .put(`/niveis/${this.nivel.id}`, { nivel: this.nivelName })
            .then((response) => {
              const {status} = response
              toast.success(`Status: ${status}. Foi possível editar usuario`)
              this.$emit("save");
              this.$emit("close");
            })
            .catch((error) => {
              console.error(error);
            });
        } else {
          apiClient
            .post("/niveis", { nivel: this.nivelName })
            .then((response) => {
              const {status} = response
              toast.success(`Status: ${status}. Foi possível cadastrar usuario`)
              this.$emit("save");
              this.$emit("close");
            })
            .catch((error) => {
              console.error(error);
            });
        }
      },
    },
  };
  </script>
  
  <style>
  .modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    width: 300px;
  }
  
  .close {
    float: right;
    font-size: 20px;
    cursor: pointer;
  }
  </style>
  