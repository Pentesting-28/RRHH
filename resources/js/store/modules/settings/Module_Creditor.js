import Api from '../../../Services';


export const module_creditor = {
    namespaced: true,
    state: {
        creditors_module:[],
        history: []
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_MODULE_CREDITOR(state) {
            return state.creditors_module;
        },
        GET_MODULE_CREDITOR_HISTORY(state) {
            return state.history;
        },
    },
    mutations: {
        SET_MODULE_CREDITOR(state, payload) {
            state.creditors_module = payload.data;
        },
        SET_MODULE_CREDITOR_HISTORY(state, payload) {
            state.history = payload.data;
        },
        SET_PUSH_MODULE_CREDITOR(state, payload) {
            state.creditors_module.push(payload.data);
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.creditors_module.splice(payload.position_array, 1, payload.data);
        },
        SET_DELETED(state, payload) {
            const position = state.creditors_module.findIndex( (element) => {
              return element.id == payload.id
            })

            if (position !== undefined) {
                state.creditors_module.splice(position, 1);
            }
        }
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/creditors_module', payload);
                commit("SET_PUSH_MODULE_CREDITOR", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/creditors_module/${payload.id}`, payload);
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

                const response = await Api.get(`/api/creditors_module`);
                commit("SET_MODULE_CREDITOR", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async HISTORY({commit}, payload) {
            try {

                const response = await Api.get(`/api/creditors_history_module`);
                commit("SET_MODULE_CREDITOR_HISTORY", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async SHOW({commit}, payload) {
            try {

                const response = await Api.get(`/api/creditors_module/${payload.id}`);
                commit("SET_MODULE_CREDITOR", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/creditors_module/${payload.id}`);
                 commit("SET_DELETED", payload.id);
                // const data = {
                //     data: response.data.data,
                //     position_array: payload.position_array
                // }
                // commit("SET_MODULE_CREDITOR", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
