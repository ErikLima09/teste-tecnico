import api from './plugins/axios'

export async function validarToken() {
    try {
        const response = await api.get('/perfil')
        return !!response.data
    } catch (err) {
        return false
    }
}