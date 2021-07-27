import Api from '../../../Services';
import ApiFile from '../../../Services/file';


export const driving_license = {
    namespaced: true,
    state: {
        driving_license:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_DRIVING_LICENSE(state) {
            return state.driving_license;
        },
    },
    mutations: {
        SET_DRIVING_LICENSE(state, payload) {
            state.driving_license = payload.data;
        },
        SET_PUSH_DRIVING_LICENSE(state, payload) {
            state.driving_license.push(payload.data);
        },
        SET_UPDATED(state, payload) {
            //state.segment = payload.data;
            state.driving_license.splice(payload.position_array, 1, payload.data);
        },
        SET_DELETE_DRIVING_LICENSE(state, payload) {
            const position = state.driving_license.findIndex( (element) => {
              return element.id == payload.id
            })

            console.log('position', position)

            if (position !== undefined) {
                state.driving_license.splice(position, 1);
            }
        },
    },
    actions: {
        async REGISTER({commit}, payload) {
            try {
                console.log(payload);
                const response = await ApiFile.post('/api/driving_license', payload.formData);
                commit("SET_PUSH_DRIVING_LICENSE", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED({commit}, payload) {
            try {
                const response = await ApiFile.post(`/api/driving_license_update/${payload.id}`, payload.formData);
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

                const response = await Api.get(`/api/driving_license/${payload.id}`);
                commit("SET_DRIVING_LICENSE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/driving_license/${payload.id}`);
                commit("SET_DELETE_DRIVING_LICENSE", payload);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async REGISTER_DNI({commit}, payload) {
            try {
                console.log(payload);
                const response = await ApiFile.post('/api/employee_dni', payload.formData);
                commit("SET_PUSH_DRIVING_LICENSE", response.data);
                console.log('********* ');
                return response.data
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED_DNI({commit}, payload) {
            try {
                const response = await ApiFile.post(`/api/employee_dni_update/${payload.id}`, payload.formData);
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
        async INDEX_DNI({commit}, payload) {
            try {

                const response = await Api.get(`/api/employee_dni/${payload.id}`);
                commit("SET_DRIVING_LICENSE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE_DNI({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/employee_dni/${payload.id}`);
                commit("SET_DELETE_DRIVING_LICENSE", payload);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
