import Api from '../../../Services';


export const reports = {
    namespaced: true,
    state: {
        reports:[]
        // pageCount: 0,
        // itemsPerPage: 0
    },
    getters: {
        GET_REPORTS(state) {
            return state.reports;
        },
    },
    mutations: {
        SET_REPORTS(state, payload) {
            state.reports = payload.data;
        },
    },
    actions: {
        
        async INDEX({commit}, payload) {
            try {
                const response = await Api.post(`/api/filtered_out/${payload.id}/${payload.departament_id}/${payload.position_id}`, payload);
                commit("SET_REPORTS", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },        

    }
};
