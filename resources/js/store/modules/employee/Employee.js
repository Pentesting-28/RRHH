import Api from '../../../Services/index';
import ApiFile from '../../../Services/file';

export const employee = {
    namespaced: true,
    state: {
        employee: [],
        department: [],
        payment_methods: [],
        position: [],
        contract_type: [],
        status_employee: [],
        license_type: [],
        license: [],
        dependent: [],
        salary: [],
        status_marital: [],
        license_letter: [],
        contract_termination: [],
        total_employee: 0,        
        employee_page_count: 0,
        history_salary: []
    },
    getters: {
        GET_EMPLOYEE(state) {
            return state.employee;
        },
        PAGINATION(state) {
            return {
                total: state.total_employee,        
                page_count: state.employee_page_count,
            };
        },
        GET_DEPARTMENT_TYPES(state) {
            return state.department;
        },
        GET_PAYMENT_METHODS(state) {
            return state.payment_methods;
        },
        GET_POSITION(state) {
            return state.position;
        },
        GET_CONTRACT_TYPE(state) {
            return state.contract_type;
        },
        GET_STATUS_EMPLOYEE(state) {
            return state.status_employee.filter( (element) => {
                      return element.id !== 2
                    })
        },
        GET_LICENSE_TYPE(state) {
            return state.license_type;
        },
        GET_LICENSE(state) {
            return state.license;
        },
        GET_DEPENDENT(state) {
            return state.dependent;
        },
        GET_SALARY(state) {
            return state.salary;
        },
        GET_HISTORY_SALARY(state) {
            return state.history_salary;
        },
        GET_SALARY_TYPE(state) {
            return state.salary_type;
        },
        GET_STATUS_MARITAL(state) {
            return state.status_marital;
        },
        GET_LICENSE_LETTER(state) {
            return state.license_letter;
        },
        GET_CONTRACT_TERMINATION(state) {
            return state.contract_termination;
        },
    },
    mutations: {
        SET_EMPLOYEE(state, payload) {
            state.employee = payload.data.data;
        },
        SET_PAGINATE(state, payload) {
            state.total_employee = payload.total;
            state.employee_page_count = payload.page_count;

            console.log('state.total_employee',state.total_employee)
            console.log('state.employee_page_count',state.employee_page_count)
        },
        SET_PUSH_EMPLOYEE(state, payload) {
            state.employee.push(payload);
        },
        SET_UPDATED_EMPLOYEE(state, payload) {
            state.employee.splice(payload.position_array, 1, payload.data);
        },
        SET_DEPARTMENT_TYPES(state, payload) {
             state.department = payload.data;
        },
        SET_PAYMENT_METHODS(state, payload) {
             state.payment_methods = payload.data;
        },
        SET_POSITION(state, payload) {
             state.position = payload.data;
        },
        SET_CONTRACT_TYPE(state, payload) {
             state.contract_type = payload.data;
        },
        SET_STATUS_EMPLOYEE(state, payload) {
             state.status_employee = payload.data;
        },
        SET_LICENSE_TYPE(state, payload) {
             state.license_type = payload.data;
        },
        SET_SALARY_TYPE(state, payload) {
            state.salary_type = payload.data;
        },
        SET_LICENSE(state, payload) {
            state.license = payload.data;
        },
        SET_DEPENDENT(state, payload) {
            state.dependent = payload.data;
        },
        SET_SALARY(state, payload) {
            state.salary = payload.data;
        },
        SET_HISTORY_SALARY(state, payload) {
            state.history_salary = payload.data;
        },
        SET_PUSH_LICENSE(state, payload) {
            state.license.push(payload);
        },
        SET_PUSH_DEPENDENT(state, payload) {
            state.license.push(payload);
        },
        SET_PUSH_SALARY(state, payload) {
            state.salary.push(payload);
        },
        SET_UPDATED_LICENSE(state, payload) {
            state.license.splice(payload.position_array, 1, payload.data);
        },
        SET_UPDATED_DEPENDENT(state, payload) {
            state.dependent.splice(payload.position_array, 1, payload.data);
        },
        SET_UPDATED_SALARY(state, payload) {
            state.salary.splice(payload.position_array, 1, payload.data);
        },
        SET_STATUS_MARITAL(state, payload) {
            state.status_marital = payload.data;
        },
        SET_LICENSE_LETTER(state, payload) {
            state.license_letter = payload.data;
        },
        SET_CONTRACT_TERMINATION(state, payload) {
            state.contract_termination = payload.data;
        },
        SET_DELETE_SALARY(state, payload) {
            const position = state.salary.findIndex( (element) => {
              return element.id == payload.id
            })

            if (position !== undefined) {
                state.salary.splice(position, 1);
            }
        },
        SET_DELETE_LICENSE(state, payload) {
            const position = state.license.findIndex( (element) => {
              return element.id == payload.id
            })

            console.log('position', position)

            if (position !== undefined) {
                state.license.splice(position, 1);
            }
        },
    },
    actions: {
        async GET_PAGINATE_EMPLOYEE({ commit }, payload) {
            try {
              const response = await Api.get(`/api/employee?page=${payload.page}`);
              commit("SET_PAGINATE", {
                total: response.data.data.total,
                page_count: Math.ceil(response.data.data.total / response.data.data.per_page)
              });
              commit("SET_EMPLOYEE", response.data);
              return response;
            } catch (error) {
              return Promise.reject(error);
            }
        },
        async REGISTER_EMPLOYEE({ commit }, payload) {
            try {
                const response = await Api.post('/api/employee', payload);
                // commit("SET_PUSH_EMPLOYEE", response.data.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

        async REGISTER_IMAGE_EMPLOYEE({ dispatch, state }, payload) {
            try {
                const response = await ApiFile.post(`/api/employeeImage/${payload.id}`, payload.formData);
                console.log('O***',response.data.data)
                // commit("SET_PUSH_EMPLOYEE", response.data.data);
                const pagination = {
                    page: state.current_page,
                    itemsPerPage: 25,
                };
                await dispatch('GET_PAGINATE_EMPLOYEE', pagination);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

        async UPDATED_IMAGE_EMPLOYEE({ dispatch, state }, payload) {
            try {
                const response = await ApiFile.post(`/api/employeeImage/${payload.id}`, payload.formData);
                // const data = {
                //     data: response.data.data,
                //     position_array: payload.position_array
                // }
                // console.log('data array positiop',data)
                // commit("SET_UPDATED_EMPLOYEE", data);
                const pagination = {
                    page: payload.page,
                    itemsPerPage: 25,
                };
                await dispatch('GET_PAGINATE_EMPLOYEE', pagination);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

        async UPDATED_EMPLOYEE({ commit }, payload) {
            try {
                const response = await Api.put(`/api/employee/${payload[0].id}`, payload);
                // const data = {
                //     data: response.data.data,
                //     position_array: payload.position_array
                // }
                // commit("SET_UPDATED_EMPLOYEE", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_EMPLOYEE({ commit }, payload) {
            try {
                const response = await Api.get('/api/employee');
                console.log(response.data.data,'ooooo')
                commit("SET_PAGINATE", {
                        total: response.data.data.total,
                        page_count: Math.ceil(response.data.data.total / 
                            response.data.data.per_page)
                      });
                commit("SET_EMPLOYEE", response.data);                
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

        async SHOW_EMPLOYEE({ commit }, payload) {
            try {
                const response = await Api.get(`/api/employee/${payload.id}`);              
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },

        async SEARCH_EMPLOYEE({ commit }, payload) {
            try {
                const response = await Api.post('/api/employee_search', payload);
                console.log(response.data.data,'ooooo')
                commit("SET_PAGINATE", {
                        total: response.data.data.total,
                        page_count: Math.ceil(response.data.data.total / 
                            response.data.data.per_page)
                      });
                commit("SET_EMPLOYEE", response.data);                
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },        
        async DEPARTAMENT_TYPES({ commit }, payload) {
            try {
                const response = await Api.get('/api/department');
                commit("SET_DEPARTMENT_TYPES", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async PAYMENT_METHODS({ commit }, payload) {
            try {
                const response = await Api.get('/api/payment_method');
                commit("SET_PAYMENT_METHODS", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async POSITION({ commit }, payload) {
            try {
                const response = await Api.get('/api/position');
                commit("SET_POSITION", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async CONTRACT_TYPE({ commit }, payload) {
            try {
                const response = await Api.get('/api/contract_type');
                commit("SET_CONTRACT_TYPE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async STATUS_EMPLOYEE({ commit }, payload) {
            try {
                const response = await Api.get('/api/status_employee');
                commit("SET_STATUS_EMPLOYEE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async LICENSE_TYPE({ commit }, payload) {
            try {
                const response = await Api.get('/api/license_type');
                commit("SET_LICENSE_TYPE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async SALARY_TYPE({ commit }, payload) {
            try {
                const response = await Api.get('/api/salary_type');
                commit("SET_SALARY_TYPE", response.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async REGISTER_LICENSE({ commit }, payload) {
            try {
                const response = await ApiFile.post('/api/license', payload.formData);
                commit("SET_PUSH_LICENSE", response.data.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async REGISTER_SALARY({ commit }, payload) {
            try {
                const response = await Api.post('/api/salary', payload);
                commit("SET_PUSH_SALARY", response.data.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED_SALARY({ commit }, payload) {
            try {
                const response = await Api.put(`/api/salary/${payload.id}`, payload);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                console.log('kk',data)
                commit("SET_UPDATED_SALARY", data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async REGISTER_DEPENDENT({ commit }, payload) {
            try {
                const response = await Api.post('/api/dependent', payload);
                commit("SET_PUSH_DEPENDENT", response.data.data);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async UPDATED_LICENSE({ commit }, payload) {
            try {
                const response = await ApiFile.post(`/api/license_update/${payload.id}`, payload.formData);
                const data = {
                    data: response.data.data,
                    position_array: payload.position_array
                }
                commit("SET_UPDATED_LICENSE", data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        }
    ,
    async UPDATED_DEPENDENT({ commit }, payload) {
        try {
            const response = await Api.put(`/api/dependent/${payload.id}`, payload);
            const data = {
                data: response.data.data,
                position_array: payload.position_array
            }
            commit("SET_UPDATED_DEPENDENT", data);
            return response;
        } catch (error) {
            return Promise.reject(error);
        }
    },
        async INDEX_LICENSE({ commit }, payload) {
            try {
                const response = await Api.get(`/api/license/${payload.id}`);
                commit("SET_LICENSE", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_DEPENDENT({ commit }, payload) {
            try {
                const response = await Api.get(`/api/dependent/${payload.id}`);
                commit("SET_DEPENDENT", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_SALARY({ commit }, payload) {
            try {
                const response = await Api.get(`/api/salary/${payload.id}`);
                commit("SET_SALARY", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async STATUS_MARITAL({ commit }, payload) {
            try {
                const response = await Api.get('/api/status_marital/');
                commit("SET_STATUS_MARITAL", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async LICENSE_LETTER({ commit }, payload) {
            try {
                const response = await Api.get('/api/license_letter/');
                commit("SET_LICENSE_LETTER", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },

        async INDEX_CONTRACT_TERMINATION({ commit }, payload) {
            try {
                const response = await Api.get(`/api/contract_termination/`);
                commit("SET_CONTRACT_TERMINATION", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        
        async DELETE_SALARY({ commit }, payload) {
            try {
                // const response = await Api.delete(`/api/salary/${payload.id}`);
                commit("SET_DELETE_SALARY", payload);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async DELETE_LICENSE({ commit }, payload) {
            try {
                const response = await Api.delete(`/api/license/${payload.id}`);

                commit("SET_DELETE_LICENSE", payload);
                return response.data;
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async INDEX_HISTORY_SALARY({ commit }, payload) {
            try {
                const response = await Api.get(`/api/salary_history_module/`);
                commit("SET_HISTORY_SALARY", response.data);
                return response;
            } catch (error) {
                return Promise.reject(error);
            }
        },

    }
};
