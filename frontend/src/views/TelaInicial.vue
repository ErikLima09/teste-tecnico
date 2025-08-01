<template>
    <v-app>
        <v-app-bar app color="red-darken-3" dark>
            <v-app-bar-title>Sistema de Produtos</v-app-bar-title>
        </v-app-bar>

        <v-navigation-drawer app color="blue-lighten-5">
            <v-list nav dense>
                <v-list-item
                    link
                    prepend-icon="mdi-account-group"
                    @click="$router.push('/telausuarios')"
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

        <v-main>
            <v-row class="mt-1 ml-1">
                <v-col cols="12">
                    <h2 class="text-h5 font-weight-bold">
                        Lista de Produtos
                    </h2>
                </v-col>
            </v-row>

            <v-container>
                <v-row class="mb-4" dense>
                    <v-col cols="12" sm="2" md="2">
                        <v-text-field
                            v-model="filtroProduto"
                            label="Buscar por nome"
                            prepend-inner-icon="mdi-magnify"
                            @input="filtrar"
                            clearable
                        />
                    </v-col>

                    <v-col cols="12" sm="2" md="2">
                        <v-text-field
                            v-model="filtroProprietario"
                            label="Buscar por proprietário"
                            prepend-inner-icon="mdi-account"
                            @input="filtrar"
                            clearable
                        />
                    </v-col>
                    
                    <v-row class="mb-4" align="center" justify="end">
                        <v-col cols="auto">
                            <v-btn color="red-darken-3" @click="abrirDialog = true">
                                Novo Produto
                            </v-btn>
                        </v-col>
                    </v-row>

                    <CadastroProduto 
                        v-model="abrirDialog"
                        @produtoCadastrado="carregarProdutos"
                    />

                    <v-dialog v-model="editarDialog" max-width="500px">
                        <v-card>
                            <v-card-title>Editar Produto</v-card-title>

                            <v-card-text>
                                <v-text-field label="Nome" v-model="produtoSelecionado.nome" :rules="[v => !!v || 'Nome é obrigatório']"/>
                                <v-text-field 
                                    label="Preço" 
                                    v-model="produtoSelecionado.preco" 
                                    type="number" 
                                    :rules="[
                                        v => !!v || 'Preço é obrigatório', 
                                        v => v > 0 || 'Preço deve ser maior que zero'
                                    ]"/>
                                <v-textarea label="Descrição" v-model="produtoSelecionado.descricao" />
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer />
                                <v-btn text @click="editarDialog = false">Cancelar</v-btn>
                                <v-btn color="red-darken-3" @click="salvarEdicao">Salvar</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>

                <v-data-table
                    :headers="headers"
                    :items="produtosFiltrados"
                    :items-per-page="10"
                    class="elevation-1"
                    density="comfortable"
                    :sort-by="['id']"
                    :sort-desc="[false]"
                >
                    <template v-slot:item.preco="{ item }">
                        R$ {{ Number(item.preco).toFixed(2).replace('.', ',') }}
                    </template>

                    <template v-slot:item.created_at="{ item }">
                        {{ formatarData(item.created_at) }}
                    </template>

                    <template v-slot:item.acoes="{ item }">
                        <v-btn
                            class="ma-2"
                            color="blue-lighten-2"
                            icon="mdi-thumb-down"
                            variant="text"
                            @click="abrirEdicao(item)"
                        >
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>

                        <v-btn
                            class="ma-2"
                            color="red-lighten-2"
                            icon="mdi-thumb-down"
                            variant="text"
                            @click="excluirProduto(item.id)"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import api from '../plugins/axios'
import CadastroProduto from '@/components/CadastroProduto.vue'

export default {
    components: {
        CadastroProduto
    },

    name: 'TelaInicial',

    data() {
        return {
            produtos: [],
            filtroProduto: '',
            filtroProprietario: '',
            headers: [
                { text: 'ID', value: 'id' },
                { text: 'Nome', value: 'nome' },
                { text: 'Preço', value: 'preco' },
                { text: 'Descrição', value: 'descricao' },
                { text: 'User ID', value: 'usuario_id' },
                { text: 'Data de Criação', value: 'created_at' },
                { text: 'Ações', value: 'acoes', sortable: false }
            ],
            abrirDialog: false,
            produtoSelecionado: null,
            editarDialog: false
        }
    },

    computed: {
        produtosFiltrados() {
            return this.produtos.filter(p =>
                p.nome.toLowerCase().includes(this.filtroProduto.toLowerCase()) &&
                p.usuario?.nome?.toLowerCase().includes(this.filtroProprietario.toLocaleLowerCase())

                // String(p.usuario_id).includes(this.filtroProprietario)
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

        abrirEdicao(produto) {
            this.produtoSelecionado = { ...produto }
            this.editarDialog = true
        },

        async salvarEdicao() {
            try {
                await api.put(`/produtos/${this.produtoSelecionado.id}`, {
                    nome: this.produtoSelecionado.nome,
                    preco: this.produtoSelecionado.preco,
                    descricao: this.produtoSelecionado.descricao,
                })
                this.editarDialog = false
                this.carregarProdutos()
            } catch (error) {
                console.error('Erro ao salvar edição:', error)
            }
        },

        async excluirProduto(id) {
            if (confirm('Tem certeza que deseja excluir este produto?')) {
                try {
                    await api.delete(`/produtos/${id}`)
                    this.carregarProdutos()
                } catch (error) {
                    console.error('Erro ao excluir produto:', error)
                }
            }
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