import Api from '../../../Services';


export const type_expense = {
    namespaced: true,
    state: {
        type_expense:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_TYPE_EXPENSE(state) {
            return state.type_expense;
        },
    },
    mutations: {
        SET_TYPE_EXPENSE(state, payload) {
            state.type_expense = payload.data;
        },
        SET_PUSH_TYPE_EXPENSE(state, payload) {
            state.type_expense.push(payload.data);
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.type_expense.splice(payload.position_array, 1, payload.data);
        },
        SET_DELETED(state, payload) {
            const position = state.type_expense.findIndex( (element) => {
              return element.id == payload.id
            })

            if (position !== undefined) {
                state.type_expense.splice(position, 1);
            }
        }
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/type_expense', payload);
                commit("SET_PUSH_TYPE_EXPENSE", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/type_expense/${payload.id}`, payload);
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

                const response = await Api.get(`/api/type_expense`);
                commit("SET_TYPE_EXPENSE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/type_expense/${payload.id}`);
                commit("SET_DELETED", payload.id);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
