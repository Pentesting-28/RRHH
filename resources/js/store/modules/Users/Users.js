import Api from '../../../Services/index';


export const users = {
    namespaced: true,
    state: {
        role: [],
        permission: [],
        users: [],
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_ROL(state) {
            return state.role;
        },
        GET_USERS(state) {
            return state.users;
        },
        GET_PERMISSION(state) {
            return state.permission;
        },
    },
    mutations: {
        SET_ROL(state, payload) {
            state.role = payload;
        },
        SET_PERMISSION(state, payload) {
            state.permission = payload.filter((index) => {
                return index.id > 1;
            });
        },
        SET_USERS(state, payload) {
            state.users = payload.data;
            state.pageCount = payload.last_page;
            state.itemsPerPage = payload.to;
        },
        SET_PUSH_USER(state, payload) {
            state.users.push(payload);
        },
        SET_UPDATED_USER(state, payload) {
            state.users.splice(payload.position_array, 1, payload.data);
            // state.users = Object.assign({}, item)
        },
    },
    actions: {
        async REGISTER_USER({ commit }, payload) {
            try {
                const response = await Api.post('/api/auth/signup', payload);
                commit("SET_PUSH_USER", response.data.data);
                return response.data;                
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED_USER({ commit }, payload) {
            try {
                const response = await Api.put(`/api/users/${payload.id}`, payload);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                commit("SET_UPDATED_USER", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_USER({ commit }, payload) {
            try {
                const response = await Api.get(`/api/users`);
                console.log(response, 'usuarios index')
                commit("SET_USERS", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async ROL_USER({ commit }, payload) {
            try {
                const response = await Api.get('/api/roles');
                commit("SET_ROL", response.data.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_PERMISSION({ commit }, payload) {
            try {
                const response = await Api.get('/api/permission');
                commit("SET_PERMISSION", response.data.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async PASSWORD({ commit }, payload) {
            try {
                const response = await Api.post('/api/auth/reset_password_user', payload);
                return response.data;                
            } catch (error) {
                return Promise.reject(error);
            }
        },
    }
};
