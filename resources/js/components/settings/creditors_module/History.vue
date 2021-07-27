<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card class="shadow-large round">
                    <v-data-table
                        :headers="headers"
                        :items="ItemsSalary"
                        :search="search"
                        class="elevation-0">
                        <template v-slot:top>
                            <v-toolbar flat color="transparent" class="round">
                                <v-toolbar-title>Historico de modulo acreedor</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical></v-divider>
                                <v-spacer></v-spacer>
                                <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Buscar"
                                    single-line
                                    hide-details
                                ></v-text-field>

                            </v-toolbar>
                        </template>
                        <template v-slot:item.amount="{ item }">
                            {{item.amount | currency}}
                        </template>
                    </v-data-table>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Swal from 'sweetalert2';
    // import dialogSalary from './Dialog';.

    export default {
        // components: {
        //     dialogSalary
        // },

        data: () => ({
            search: '',
            employee_id: '',
            active_l: false,
            data_dependent: {},
            edit_l: false,
            data_edit: {},
            active: false,
            snackbar: false,
            text: '',
            loading: false,
            menu1: false,
            menu2: false,
            e1: 1,
            edit: false,
            position_array: '',
            id_user: 0,
            itemsPerPage: 10,
            dialog: false,
            headers: [
                {text: 'Usuario del sistema', align: 'left', sortable: false, value: 'user.name', class: 'length_text'},
                {text: 'Cedula', value: 'employee.dni', class: 'length_text'},
                {text: 'Empleado', value: 'employee.name', class: 'length_text'},
                {text: 'Monto', value: 'amount', class: 'length_text'},
                {text: 'Accion', value: 'action', class: 'length_text'},
            ],
            desserts: [],
        }),


        computed: {
            formTitle() {
                return this.edit === false ? 'Nuevo Salario' : 'Editar Salario'
            },
            ItemsSalary() {
                return this.$store.getters["module_creditor/GET_MODULE_CREDITOR_HISTORY"];
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
        },

        created() {
            this.initialize();
            // this.salary_type();
        },

        methods: {
            async initialize() {
                try {
                    const request = {
                        id: this.$route.params.id
                    }
                    const response = await this.$store.dispatch("module_creditor/HISTORY", request);
                } catch (error) {
                    console.log(error);
                }
            }
        }
            
    }
</script>

<style>
    .length_text {
        font-size: 1rem !important
    }
</style>
