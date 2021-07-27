import Api from '../../../Services';


export const payment_method = {
    namespaced: true,
    state: {
        payment_method:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_PAYMENT_METHOD(state) {
            return state.payment_method;
        },
    },
    mutations: {
        SET_PAYMENT_METHOD(state, payload) {
            state.payment_method = payload.data;
        },
        SET_PUSH_PAYMENT_METHOD(state, payload) {
            state.payment_method.push(payload.data);
        },
        SET_UPDATED_USER(state, payload) {
            state.users.splice(payload.payment_method_array, 1, payload.data);
            // state.users = Object.assign({}, item)
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.payment_method.splice(payload.payment_method_array, 1, payload.data);
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/payment_method', payload);
                commit("SET_PUSH_PAYMENT_METHOD", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/payment_method/${payload.id}`, payload);
                const data = {
                    data: response.data.data,
                    payment_method_array: payload.payment_method_array
                }
                commit("SET_UPDATED", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_PAYMENT_METHOD({commit}, payload) {
            try {

                const response = await Api.get(`/api/payment_method`);
                commit("SET_PAYMENT_METHOD", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/payment_method/${payload.id}`);
                const data = {
                    data: response.data.data,
                    payment_method_array: payload.payment_method_array
                }
                commit("SET_PAYMENT_METHOD", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
