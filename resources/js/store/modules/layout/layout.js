import Api from '../../../Services/index';

export const layout = {
    namespaced: true,
    state: {
        // y aqui es donde declaramos las variables del estado
        drawer: true
    },
    getters: {

        DRAWER_VALUE(state) {
            return state.drawer;
        }

        // aqui es donde retornamos los valores de las variables del estado a los componentes
        // de vue
    },
    mutations: {
        SET_DRAWER(state, payload) {
            state.drawer = payload;
        }

        // las funciones pueden llamar a los mutadores y aqui es donde le colocamos valor
        // a las variables del estado
    },
    actions:{
        // estas son las funciones, aqui es donde haremos las solicitudes a los endpoint
    }
};
