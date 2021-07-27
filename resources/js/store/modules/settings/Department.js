import Api from '../../../Services';


export const department = {
    namespaced: true,
    state: {
        department:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_DEPARTMENT(state) {
            return state.department;
        },
    },
    mutations: {
        SET_DEPARTMENT(state, payload) {
            state.department = payload.data;
        },
        SET_PUSH_DEPARTMENT(state, payload) {
            state.department.push(payload.data);
        },
        SET_UPDATED_USER(state, payload) {
            state.users.splice(payload.position_array, 1, payload.data);
            // state.users = Object.assign({}, item)
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.department.splice(payload.position_array, 1, payload.data);
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/department', payload);
                commit("SET_PUSH_DEPARTMENT", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/department/${payload.id}`, payload);
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
        async INDEX_DEPARTMENT({commit}, payload) {
            try {

                const response = await Api.get(`/api/department`);
                commit("SET_DEPARTMENT", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/department/${payload.id}`);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                commit("SET_DEPARTMENT", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
