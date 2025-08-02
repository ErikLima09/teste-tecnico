<template>
    <v-dialog v-model="dialog" max-width="500px">
        <v-card>
            <v-card-title>Cadastrar Usuário</v-card-title>
            
            <v-form ref="form">
                <v-card-text>
                    <v-text-field label="Nome" v-model="form.nome" required :rules="[v => !!v || 'Nome é obrigatório']"/>
                    <v-text-field 
                        label="CPF" 
                        v-model="form.cpf" 
                        required :rules="[
                            v => !!v || 'CPF é obrigatório',
                            v => v.length >= 11 || 'CPF deve ter ao menos 11 dígitos'
                        ]"
                    />
                    <v-text-field 
                        label="Email" 
                        v-model="form.email" 
                        required 
                        type="email" 
                        :rules="[v => !!v || 'E-mail é obrigatório', v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) || 'E-mail inválido'
]"
                    />
                    <v-text-field 
                        label="Senha"
                        v-model="form.password" 
                        required 
                        type="password" 
                        :rules="[
                            v => !!v || 'Senha é obrigatória',
                            v => v.length >= 8 || 'Senha deve ter ao menos 8 caracteres'
                        ]"
                    />
                </v-card-text>
            </v-form>
            
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
            const isValid = this.$refs.form.validate()
            if (!isValid) return
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
