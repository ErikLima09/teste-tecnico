<template>
    <v-app>
        <!-- Barra Superior -->
        <v-app-bar app color="primary" dark>
            <v-app-bar-title>Sistema de Produtos</v-app-bar-title>
        </v-app-bar>

        <!-- Menu Lateral -->
        <v-navigation-drawer app>
            <v-list nav dense>
                <v-list-item
                    link
                    prepend-icon="mdi-account-group"
                    @click="$router.push('/usuarios')"
                >
                <v-list-item-title>Usuários</v-list-item-title>
                </v-list-item>

                <v-list-item
                    link
                    prepend-icon="mdi-cube"
                    @click="$router.push('/telainicial')"
                >
                <v-list-item-title>Produtos</v-list-item-title>
                </v-list-item>

                <v-list-item
                    link
                    prepend-icon="mdi-logout"
                    @click="logout"
                >
                    <v-list-item-title>Sair</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Conteúdo Principal -->
        <v-main>
            <v-container>
                <!-- Filtros -->
                <v-row class="mb-4" dense>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field
                            v-model="filtroNome"
                            label="Buscar por nome"
                            prepend-inner-icon="mdi-magnify"
                            @input="filtrar"
                            clearable
                        />
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                        <v-text-field
                            v-model="filtroProprietario"
                            label="Buscar por proprietário"
                            prepend-inner-icon="mdi-account"
                            @input="filtrar"
                            clearable
                        />
                    </v-col>
                </v-row>
                <!-- Tabela -->
                <v-data-table
                    :headers="headers"
                    :items="produtos"
                    :items-per-page="10"
                    class="elevation-1"
                    density="comfortable"
                >
                    <template v-slot:item.preco="{ item }">
                        R$ {{ Number(item.preco).toFixed(2).replace('.', ',') }}
                    </template>

                    <template v-slot:item.created_at="{ item }">
                        {{ formatarData(item.created_at) }}
                    </template>
                </v-data-table>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import api from '../plugins/axios'

export default {

    name: 'TelaInicial',

    data() {
        return {
            produtos: [],
            filtroNome: '',
            filtroProprietario: '',
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Nome', value: 'nome' },
                { text: 'Preço', value: 'preco' },
                { text: 'Descrição', value: 'descricao' },
                { text: 'User ID', value: 'usuario_id' },
                { text: 'Data de Criação', value: 'created_at' },
            ],
        }
    },

    computed: {
        produtosFiltrados() {
            return this.produtos.filter(p =>
                p.nome.toLowerCase().includes(this.filtroNome.toLowerCase()) &&
                p.usuario?.nome?.toLowerCase().includes(this.filtroProprietario.toLowerCase())
            )
        },
    },

    methods: {
        async carregarProdutos() {
            try {
                const response = await api.get('/produtos')
                this.produtos = response.data
            } catch (error) {
                console.error('Erro ao carregar produtos:', error)
            }
        },

        formatarData(data) {
            const d = new Date(data)
            return d.toLocaleDateString('pt-BR')
        },

        filtrar() {
        },

        logout() {
            localStorage.removeItem('token')
            this.$router.push('/login')
        },
    },

    mounted() {
        this.carregarProdutos()
    },
}
</script>