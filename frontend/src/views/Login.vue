<template>
    <v-container class="d-flex justify-center align-center" style="height: 100vh;">
        <v-card width="400">
            <v-card-title class="text-h5">Login</v-card-title>
            <v-card-text>
                <v-form @submit.prevent="login">
                    <v-text-field v-model="email" label="Email" required />
                    <v-text-field v-model="password" label="Senha" type="password" required />

                    <v-btn type="submit" color="primary" block>Entrar</v-btn>
                </v-form>
                <div v-if="error" class="text-red mt-2">{{  error  }}</div>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            email: '',
            password: '',
            error: null,
        }
    },

    methods: {
        async login() {
            try {
                const response = await axios.post('http://localhost:8000/api/login', {
                    email: this.email,
                    password: this.password,
                })

                localStorage.setItem('token', response.data.token)
                this.$router.push('/telainicial') // redireciona
            } catch (error) {
                this.error = 'Credenciais inválidas'
                console.error(error)
            }
        }
    }
}
</script>