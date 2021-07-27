import Api from '../../../Services';


export const bank = {
    namespaced: true,
    state: {
        bank:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_BANK(state) {
            return state.bank;
        },
    },
    mutations: {
        SET_BANK(state, payload) {
            state.bank = payload.data;
        },
        SET_PUSH_BANK(state, payload) {
            state.bank.push(payload.data);
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.bank.splice(payload.position_array, 1, payload.data);
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/bank', payload);
                commit("SET_PUSH_BANK", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/bank/${payload.id}`, payload);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                commit("SET_UPDATED", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_BANK({commit}, payload) {
            try {

                const response = await Api.get(`/api/bank`);
                commit("SET_BANK", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/bank/${payload.id}`);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                commit("SET_BANK", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
