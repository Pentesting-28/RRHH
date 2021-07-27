<template>
    <v-navigation-drawer
        v-model="Drawer"
        app>
        <v-list dense>
            <template v-for="item in items">
                <v-list-group
                    v-if="item.children && permission.includes(item.permission)"
                    :key="item.text"
                    v-model="item.model"
                    :prepend-icon="item.model ? item.icon : item['icon-alt']"
                    append-icon=""
                    value="false">
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </template>
                    <v-list-item
                        v-for="(child, i) in item.children"
                        :key="i"
                        v-on:click="router(child.href)"
                        link>
                        <v-list-item-action v-if="child.icon">
                            <v-icon>{{ child.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ child.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
                <v-list-item
                    v-else-if="permission.includes(item.permission)"
                    :key="item.text"
                    v-on:click="router(item.href)"
                    link>
                    <v-list-item-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ item.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        data() {
            return {
                role: '',
                permission: [],
                drawer: null,
                items: [
                    {
                        icon: 'mdi-home',
                        text: 'Dashboard',
                        href: "dashboard",
                        permission: 1
                    },
                    {
                        icon: 'mdi-account-group',
                        text: 'Usuarios',
                        href: "user",
                        permission: 2
                    },
                    {
                        icon: 'mdi-account',
                        text: 'Empleados',
                        href: "employee",
                        permission: 3
                    },
                    {
                        icon: 'mdi-file',
                        text: 'Reportes',
                        href: "reports",
                        permission: 3
                    },
                    {
                        icon: 'mdi-chevron-up',
                        'icon-alt': 'mdi-chevron-down',
                        text: 'Configuraciones',
                        model: false,
                        permission: 4,
                        children: [
                            {icon: 'mdi-vector-intersection', text: 'Departamentos', href: "department"},
                            {icon: 'mdi-ruler-square-compass', text: 'Posiciones', href: "position"},
                            {icon: 'mdi-credit-card-outline', text: 'Metodo de pago', href: "payment_method"},
                            {icon: 'mdi-card-account-details-outline', text: 'Tipos de carnet', href: "license_type"},
                            {icon: 'mdi-account-cash-outline', text: 'Tipos de salario', href: "salary_type"},
                            {icon: 'mdi-bank', text: 'Bancos', href: "bank"},
                            {icon: 'mdi-file', text: 'Tipo de gasto', href: "type_expense"},
                            {icon: 'mdi-bank', text: 'Acreedor', href: "creditor"},
                            {icon: 'mdi-bank', text: 'Historico de salario', href: "salary_history"},
                            {icon: 'mdi-bank', text: 'Historico de modulo acreedores', href: "creditor_history"},
                            // {icon: 'mdi-bank', text: 'Modulo Acreedor', href: "module_creditor"},
                        ],
                    },

                ],
                mini: true
            };
        },
        mounted() {
            this.role = localStorage.getItem("role_id");
            this.permission = JSON.parse(`[ ${localStorage.getItem("permission_id")} ]`);
        },
        computed: {
            Drawer: {
                get() {
                    let drawer = this.$store.getters["layout/DRAWER_VALUE"];
                    return drawer === null ? true : drawer;
                },
                set(val) {
                    let drawer = this.$store.getters["layout/DRAWER_VALUE"];
                    this.$store.commit("layout/SET_DRAWER", val);
                }
            },
        },
        created() {
        },
        methods: {
            router(route) {
                console.log("Router", route)
                this.$router.push({name: route}).catch(err => {
                });
            },
        }
    };
</script>

<style>
    /*.theme--light.v-list-item:hover:before {
        opacity: .3;
        background: #0d173b;
    }*/
    .mostaza--text {
        color: #d98f07 !important;
    }
</style>
