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
                        Lista de Usuários
                    </h2>
                </v-col>
            </v-row>
        
            <v-container>
                <v-row class="mb-8" align="center">
                    <v-col cols="12" sm="4">
                        <v-text-field
                            v-model="filtroNome"
                            label="Buscar por nome"
                            prepend-inner-icon="mdi-magnify"
                            clearable
                        />
                    </v-col>

                    <v-row class="mb-4" align="center" justify="end">
                        <v-col cols="2">
                            <v-btn color="red-darken-3" @click="abrirDialog = true">
                                Novo Usuário
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-row>

                <CadastroUsuario
                    v-model="abrirDialog"
                    @usuarioCadastrado="carregarUsuarios"
                />

                <v-dialog v-model="editarDialog" max-width="500px">
                    <v-card>
                        <v-card-title>Editar Usuário</v-card-title>
                        
                        <v-card-text>
                            <v-text-field label = "Nome"  v-model = "usuarioSelecionado.nome" :rules="[v => !!v || 'Nome é obrigatório']" />
                            <v-text-field 
                                label="CPF"
                                v-model="usuarioSelecionado.cpf" 
                                :rules="[v => !!v || 'CPF é obrigatório', v => v.length >= 11 || 'CPF deve ter pelo menos 11 dígitos']"
                                required
                            />
                            <v-text-field 
                                label="Email"
                                v-model="usuarioSelecionado.email"
                                :rules="[v => !!v || 'E-mail é obrigatório', v => /.+@.+\..+/.test(v) || 'E-mail inválido']"
                                required
                            />
                            <v-text-field 
                                label="Senha"
                                v-model="usuarioSelecionado.password"
                                type="password"
                                :rules="[v => !v || v.length >= 8 || 'Senha deve ter pelo menos 8 caracteres']"
                            />
                        </v-card-text>
                        
                        <v-card-actions>
                            <v-spacer />
                            <v-btn text @click = "editarDialog = false">Cancelar</v-btn>
                            <v-btn color = "red-darken-3" @click="salvarEdicao">Salvar</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-data-table
                    :headers="headers"
                    :items="usuariosFiltrados"
                    class="elevation-1"
                    :items-per-page="10"
                >
                    <template v-slot:item.created_at="{ item }">
                        {{  formatarData(item.created_at) }}
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
                            @click="excluirUsuario(item.id)"
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
import CadastroUsuario from '@/components/CadastroUsuario.vue'

export default {
    components: { CadastroUsuario },
  
    data() {
        return {
            usuarios: [],
            filtroNome: '',
            abrirDialog: false,
            editarDialog: false,
            usuarioSelecionado: null,
            headers: [
                { title: 'ID', key: 'id' },
                { title: 'Nome', key: 'nome' },
                { title: 'CPF', key: 'cpf' },
                { title: 'E-mail', key: 'email' },
                { title: 'Criado em', key: 'created_at' },
                { title: 'Ações', key: 'acoes', sortable: false },
            ],
        }
    },
    
    computed: {
        usuariosFiltrados() {
            return this.usuarios.filter(u =>
                u.nome.toLowerCase().includes(this.filtroNome.toLowerCase())
            )
        },
    },

    methods: {
        async carregarUsuarios() {
            const res = await api.get('/usuarios')
            this.usuarios = res.data.data || res.data
        },

        formatarData(data) {
            const d = new Date(data)
            return d.toLocaleDateString('pt-BR')
        },

        abrirEdicao(usuario) {
            this.usuarioSelecionado = { ...usuario, password: '' }
            this.editarDialog = true
        },
        
        async salvarEdicao() {
            try {
                await api.put(`/usuarios/${this.usuarioSelecionado.id}`, this.usuarioSelecionado)
                this.editarDialog = false
                this.carregarUsuarios()
            } catch (e) {
                console.error('Erro ao editar:', e)
            }
        },
        
        async excluirUsuario(id) {
            if (confirm('Deseja realmente excluir este usuário?')) {
                await api.delete(`/usuarios/${id}`)
                this.carregarUsuarios()
            }
        },

        logout() {
            localStorage.removeItem('token')
            this.$router.push('/login')
        }
    },

    mounted() {
        this.carregarUsuarios()
    },
}
</script>
