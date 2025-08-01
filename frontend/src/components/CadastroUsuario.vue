<template>
    <v-dialog v-model="dialog" max-width="500px">
        <v-card>
            <v-card-title>Cadastrar Usuário</v-card-title>
            
            <v-card-text>
                <v-text-field label="Nome" v-model="form.nome" required />
                <v-text-field label="CPF" v-model="form.cpf" required />
                <v-text-field label="Email" v-model="form.email" required type="email" />
                <v-text-field label="Senha" v-model="form.password" required type="password" />
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

    name: 'CadastroUsuario',
    props: {
        modelValue: Boolean,
    },
    emits: ['update:modelValue', 'usuarioCadastrado'],
    
    data() {
        return {
            dialog: this.modelValue,
            form: {
                nome: '',
                cpf: '',
                email: '',
                password: '',
            },
        }
    },

    watch: {
        modelValue(val) {
            this.dialog = val
        },

        dialog(val) {
            this.$emit('update:modelValue', val)
        },
    },

    methods: {
        async salvar() {
            try {
                await api.post('/usuarios', this.form)
                this.$emit('usuarioCadastrado')
                this.fechar()
            } catch (error) {
                console.error('Erro ao salvar usuário:', error)
            }
        },
        
        fechar() {
            this.dialog = false
            this.form = { nome: '', cpf: '', email: '', password: '' }
        },
    },
}
</script>
