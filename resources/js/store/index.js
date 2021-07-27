import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import {layout} from './modules/layout/layout';
import {auth} from './modules/Auth/Auth';
import {users} from "./modules/Users/Users";
import {department} from "./modules/settings/Department";
import {position} from "./modules/settings/Position";
import {payment_method} from "./modules/settings/PaymentMethod";
import {licenseType} from "./modules/settings/LicenseType";
import {employee} from "./modules/employee/Employee";
import {salary_type} from "./modules/settings/SalaryType";
import {bank} from "./modules/settings/Bank";
import {driving_license} from "./modules/driving_license/driving_license";
import {creditor} from "./modules/settings/Creditor";
import {module_creditor} from "./modules/settings/Module_Creditor";
import {type_expense} from "./modules/settings/Type_Expense";
import {reports} from "./modules/settings/Reports";


export default new Vuex.Store({
    modules: {
        layout,
        auth,
        users,
        department,
        position,
        payment_method,
        licenseType,
        employee,
        salary_type,
        bank,
        driving_license,
        creditor,
        module_creditor,
        type_expense,
        reports
    },
    state: {},
    getters: {},
    mutations: {},
    actions: {}
});
