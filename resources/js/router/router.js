// este es un esqueleto basico que realizo para las rutas
import Vue from 'vue';
import Router from 'vue-router';
import store from '../store/index';

Vue.use(Router);

const router = new Router({
    routes: [
        {
            name: "login",
            path: "/",
            component: () =>
                import(/* webpackChunkName: "login" */ "../components/auth/Login"),
        },
        {
            name: "layout",
            path: "/layout",
            meta: {
                requiresAuth: true
            },
            component: () =>
                import(/* webpackChunkName: "layout" */ "../components/layout/Layout"),
            children: [
                {
                    name: "dashboard",
                    path: "/dashboard",
                    meta: {
                        checkRole: [2, 1]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/layout/Dashboard"),
                },
                {
                    name: "user",
                    path: "/addUser",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/users/Index"),
                },
                {
                    name: "department",
                    path: "/addDepartment",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/department/Index"),
                },
                {
                    name: "bank",
                    path: "/addBank",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/bank/Index"),
                },
                {
                    name: "position",
                    path: "/addPosition",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/position/Index"),
                },
                {
                    name: "employee",
                    path: "/employee",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/Index"),
                },
                {
                    name: "payment_method",
                    path: "/addPaymentMethod",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/payment_method/Index"),
                },
                {
                    name: "license_type",
                    path: "/addLicenseType",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/license/Index"),
                },
                {
                    name: "license",
                    path: "/license/:id",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/license"),
                },
                {
                    name: "driving_license",
                    path: "/driving_license/:id",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/driving_license/Index"),
                },
                // {
                //     name: "dependent",
                //     path: "/dependent/:id",
                //     meta: {
                //         checkRole: [2]
                //     },
                //     component: () =>
                //         import(/* webpackChunkName: "user" */ "../components/employee/dependent/Index"),
                // },
                {
                    name: "salary_type",
                    path: "/addSalaryType",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/salary/Index"),
                },
                {
                    name: "salary",
                    path: "/salary/:id",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/salary/Index"),
                },
                {
                    name: "dni",
                    path: "/dni/:id",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/dni/Index"),
                },
                {
                    name: "type_expense",
                    path: "/type-expense",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/type_expense/Index.vue"),
                },
                {
                    name: "creditor",
                    path: "/creditor",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/creditor/Index.vue"),
                },
                {
                    name: "module_creditor",
                    path: "/module_creditor/:id",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/creditors_module/Index.vue"),
                },
                {
                    name: "employee_detail",
                    path: "/employee_detail/:id",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/EmployeeShow.vue"),
                },
                {
                    name: "salary_history",
                    path: "/salary_history",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/salary/History"),
                },
                {
                    name: "creditor_history",
                    path: "/creditor_history",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/settings/creditors_module/History"),
                },
                {
                    name: "reports",
                    path: "/reports",
                    meta: {
                        checkRole: [2]
                    },
                    component: () =>
                        import(/* webpackChunkName: "user" */ "../components/employee/reports/Index"),
                },
                
            ]
        }
    ],
    mode: "history",
    scrollBehavior(to, from, savedPosition) {
        // return desired position
        return { x: 0, y: 0 }
    }
});


 router.beforeEach((to, from, next) => {
    // Consulta VUEX
    const authUser = store.getters["auth/IS_AUTHENTICATED"];
    const role = localStorage.getItem("role_id");
//     // CREACION META
//     const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
//     const checkRole = to.matched.some(record => record.meta.checkRole);

    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!authUser) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath
                }
            });
        } else {
            console.log(to.meta.checkRole.includes(parseInt(role)))
            if (to.meta.checkRole.includes(parseInt(role))) {
                next();
            } else {
                router.push({
                    name: "dashboard"
                });
            }
        }
    } else {
        next(); // make sure to always call next()!
    }
});
export default router;
