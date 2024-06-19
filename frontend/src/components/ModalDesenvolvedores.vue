<template>
    <div class="modal">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>{{ desenvolvedor ? 'Editar Desenvolvedor' : 'Adicionar Desenvolvedor' }}</h2>
            <input v-model="nome" placeholder="Nome" />
            <div>
                <label for="sexo">Sexo:</label>
                <input type="radio" id="sexo-m" value="M" v-model="sexo" />
                <label for="sexo-m">Masculino</label>
                <input type="radio" id="sexo-f" value="F" v-model="sexo" />
                <label for="sexo-f">Feminino</label>
            </div>
            <label for="dataNascimento">Data de Nascimento:</label>
            <input type="date" id="dataNascimento" v-model="dataNascimento" />
            <input v-model="hobby" placeholder="Hobby" />
            <div>
                <label for="nivelId">Nível:</label>
                <select id="nivelId" v-model="nivelId">
                    <option v-for="nivel in niveis" :key="nivel.id" :value="nivel.id">{{ nivel.nivel }}</option>
                </select>
            </div>
            <button @click="saveDesenvolvedor">{{ desenvolvedor ? 'Salvar' : 'Adicionar' }}</button>
        </div>
    </div>
</template>

<script>
import apiClient from "@/api";
import { useToast } from 'vue-toast-notification';
const toast = useToast();

export default {
    props: {
        desenvolvedor: {
            type: Object,
            default: null,
        },
    },
    data() {


        return {
            niveis: [],
            id: this.desenvolvedor ? this.desenvolvedor.id : "",
            nome: this.desenvolvedor ? this.desenvolvedor.nome : "",
            sexo: this.desenvolvedor ? this.desenvolvedor.sexo : "",
            dataNascimento: this.desenvolvedor ? this.desenvolvedor.data_nascimento : "",
            hobby: this.desenvolvedor ? this.desenvolvedor.hobby : "",
            nivelId: this.desenvolvedor ? this.desenvolvedor.nivel_id : "",
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
                    console.error(error);
                });
        },
        saveDesenvolvedor() {
            const data = {
                id: this.id,
                nome: this.nome,
                sexo: this.sexo,
                data_nascimento: this.dataNascimento,
                hobby: this.hobby,
                nivel_id: this.nivelId,
            };

            if (this.desenvolvedor) {
                apiClient
                    .put(`/desenvolvedores/${this.id}`, data)
                    .then((response) => {
                        const { status } = response
                        toast.success(`Status: ${status}. Foi possivel atualizar o desenvoveldor`)
                        this.$emit("save");
                        this.$emit("close");
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            } else {
                apiClient
                    .post("/desenvolvedores", data)
                    .then((response) => {
                        const { status } = response
                        toast.success(`Status: ${status}. Foi possivel criar o desenvoveldor`)
                        this.$emit("save");
                        this.$emit("close");
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>

<style>
input,
select {
    margin: 8px 0;
}
</style>
