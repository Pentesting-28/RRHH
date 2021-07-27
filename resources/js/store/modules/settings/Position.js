import Api from '../../../Services';


export const position = {
    namespaced: true,
    state: {
        position:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_POSITION(state) {
            return state.position;
        },
    },
    mutations: {
        SET_POSITION(state, payload) {
            state.position = payload.data;
        },
        SET_PUSH_POSITION(state, payload) {
            state.position.push(payload.data);
        },
        SET_UPDATED_USER(state, payload) {
            state.users.splice(payload.position_array, 1, payload.data);
            // state.users = Object.assign({}, item)
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.position.splice(payload.position_array, 1, payload.data);
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await Api.post('/api/position', payload);
                commit("SET_PUSH_POSITION", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await Api.put(`/api/position/${payload.id}`, payload);
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
        async INDEX_POSITION({commit}, payload) {
            try {

                const response = await Api.get(`/api/position`);
                commit("SET_POSITION", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/position/${payload.id}`);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                commit("SET_POSITION", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
