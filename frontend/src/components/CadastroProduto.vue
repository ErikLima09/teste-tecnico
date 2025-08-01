<template>
    <v-dialog v-model="dialog" max-width="500px">
        <v-card>
            <v-card-title>Cadastrar Produto</v-card-title>

            <v-card-text>
                <v-text-field label="Nome" v-model="form.nome" />
                <v-text-field label="Preço" v-model="form.preco" />
                <v-text-field label="Descrição" v-model="form.descricao" />

                <v-select
                    label="Usuário"
                    :items="usuarios"
                    item-title="nome"
                    item-value="id"
                    v-model="form.usuario_id"
                    required
                />
            </v-card-text>

            <v-card-actions>
                <v-spacer />
                <v-btn text @click="fechar">Cancelar</v-btn>
                <v-btn color="red-darken-3" @click="salvar">Salvar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import api from '../plugins/axios'

    export default {
        name: 'CadastroProduto',
        props: {
            modelValue: Boolean, // Controla a abertura do dialog
        },
        emits: ['update:modelValue', 'produtoCadastrado'],

        data() {
            return {
                dialog: this.modelValue,
                form: {
                    name: '',
                    preco: '',
                    descricao: '',
                    usuario_id: null,
                },
                usuarios: [],
            }
        },

        watch: {
            modelValue(val) {
                this.dialog = val
                if (val) this.carregarUsuarios()
            },
            dialog(val) {
                this.$emit('update:modelValue', val)
            },
        },

        methods: {
            async carregarUsuarios() {
                const res = await api.get('/usuarios')
                this.usuarios = res.data.data
            },
            async salvar() {
                try {
                    await api.post('/produtos', {
                        nome: this.form.nome,
                        preco: this.form.preco,
                        descricao: this.form.descricao,
                        usuario_id: this.form.usuario_id,
                    })
                    this.$emit('produtoCadastrado') // notifica o pai
                    this.dialog = false
                    this.resetar()
                } catch (error) {
                    console.error('Erro ao salvar produto:', error)
                }
            },

            resetar() {
                this.form = {nome: '', preco: '', descricao: '', usuario_id: null}
            },

            fechar() {
                this.dialog = false
                this.resetar()
            },
        },
    }
</script>