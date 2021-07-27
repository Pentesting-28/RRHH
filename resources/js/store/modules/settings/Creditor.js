import Api from '../../../Services';


export const creditor = {
    namespaced: true,
    state: {
        creditor:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_CREDITOR(state) {
            return state.creditor;
        },
    },
    mutations: {
        SET_CREDITOR(state, payload) {
            state.creditor = payload.data;
        },
        SET_PUSH_CREDITOR(state, payload) {
            state.creditor.push(payload.data);
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.creditor.splice(payload.position_array, 1, payload.data);
        },
        SET_DELETED(state, payload) {
            const position = state.creditor.findIndex( (element) => {
              return element.id == payload.id
            })

            if (position !== undefined) {
                state.creditor.splice(position, 1);
            }
        }
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/creditor', payload);
                commit("SET_PUSH_CREDITOR", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/creditor/${payload.id}`, payload);
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
        async INDEX({commit}, payload) {
            try {

                const response = await Api.get(`/api/creditor`);
                commit("SET_CREDITOR", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/creditor/${payload.id}`);
                commit("SET_DELETED", payload.id);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
