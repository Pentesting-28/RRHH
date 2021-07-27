import Api from '../../../Services';


export const licenseType = {
    namespaced: true,
    state: {
        license:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_LICENSE(state) {
            return state.license;
        },
    },
    mutations: {
        SET_LICENSE(state, payload) {
            state.license = payload.data;
        },
        SET_PUSH_LICENSE(state, payload) {
            state.license.push(payload.data);
        },
        SET_UPDATED_USER(state, payload) {
            state.users.splice(payload.license_array, 1, payload.data);
            // state.users = Object.assign({}, item)
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.license.splice(payload.license_array, 1, payload.data);
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/license_type', payload);
                commit("SET_PUSH_LICENSE", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/license_type/${payload.id}`, payload);
                const data = {
                    data: response.data.data,
                    license_array: payload.license_array
                }
                commit("SET_UPDATED", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_LICENSE({commit}, payload) {
            try {

                const response = await Api.get(`/api/license_type`);
                commit("SET_LICENSE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/license_type/${payload.id}`);
                const data = {
                    data: response.data.data,
                    license_array: payload.license_array
                }
                commit("SET_LICENSE", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
