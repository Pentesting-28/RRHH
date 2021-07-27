import Api from '../../../Services';


export const salary_type = {
    namespaced: true,
    state: {
        salary_type:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_SALARY_TYPE(state) {
            return state.salary_type;
        },
    },
    mutations: {
        SET_SALARY_TYPE(state, payload) {
            state.salary_type = payload.data;
        },
        SET_PUSH_SALARY_TYPE(state, payload) {
            state.salary_type.push(payload.data);
        },
        SET_UPDATED_USER(state, payload) {
            state.users.splice(payload.salary_type_array, 1, payload.data);
            // state.users = Object.assign({}, item)
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.salary_type.splice(payload.salary_type_array, 1, payload.data);
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/salary_type', payload);
                commit("SET_PUSH_SALARY_TYPE", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/salary_type/${payload.id}`, payload);
                const data = {
                    data: response.data.data,
                    salary_type_array: payload.salary_type_array
                }
                commit("SET_UPDATED", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_SALARY_TYPE({commit}, payload) {
            try {

                const response = await Api.get(`/api/salary_type`);
                commit("SET_SALARY_TYPE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/salary_type/${payload.id}`);
                const data = {
                    data: response.data.data,
                    salary_type_array: payload.salary_type_array
                }
                commit("SET_SALARY_TYPE", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
