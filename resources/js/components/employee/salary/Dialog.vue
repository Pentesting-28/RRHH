<template>
    <v-dialog v-model="active" max-width="400px" persistent>

        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="12">
                                <ValidationProvider name="salary_type_id" rules="required" v-slot="{ errors }">
                                    <v-autocomplete
                                        v-model="editedItem.salary_type_id"
                                        :items="ItemsSalaryType"
                                        item-text="name"
                                        item-value="id"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        label="Tipo de salario"
                                        :error-messages="errors"
                                    ></v-autocomplete>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12">
                                <ValidationProvider name="name" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        prefix="$"
                                        type="number"
                                        :hint="currencyFormat(editedItem.salary)"
                                        v-model="editedItem.salary"
                                        label="Salario"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-btn
                      color="primary"
                      @click="passes(save)">
                      Guardar
                  </v-btn>

                  <v-btn text @click="close">Cancelar</v-btn>
                </v-card-actions>
            </ValidationObserver>


        </v-card>
    </v-dialog>
</template>
<script>
    import Swal from 'sweetalert2';

    export default {
        props: ["active", "editedItem", "edit", "employee_id"],

        data: () => ({
            snackbar: false,
            text: '',
            loading: false,
            menu1: false,
            menu2: false,
            menu3: false,
            e1: 1,
            position_array: '',
            id_user: 0,
            itemsPerPage: 10,
            desserts: [],
            editedIndex: -1,
            password: '',
            files: [],
            confirm_password: '',
            defaultItem: {
                name: '',
                last_name: '',
                dni: '',
                relationship: '',
                age: '',
                // permission: []
            },
        }),

        computed: {
            formTitle() {
                return this.edit === false ? 'Nuevo Salario' : 'Editar Salario'
            },
            ItemsSalaryType() {
                return this.$store.getters["salary_type/GET_SALARY_TYPE"];
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
        },

        methods: {

            currencyFormat(valor) {

                let value = 0;

                if (valor > 0) {
                    value = valor;
                }
                const VALUE_FORMAT = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currencyDisplay: "symbol",
                    currencySign: "accounting",
                    currency: "USD"
                }).format(value);

                return VALUE_FORMAT;
            },

            close() {
                this.$emit("dialog:change", "cerrar_license");
            },


            async save() {
                //   editar
                if (this.edit === true) {
                    //   Object.assign(this.desserts[this.editedIndex], this.editedItem)
                    const request = {
                        id: this.editedItem.id,
                        employee_id: this.editedItem.employee_id,
                        salary_type_id: this.editedItem.salary_type_id,
                        salary: this.editedItem.salary,

                        position_array: this.editedItem.position_array
                    }

                    console.log(request, 'editar')
                    try {
                        const response = await this.$store.dispatch("employee/UPDATED_SALARY", request);
                        console.log(response);

                        this.$refs.obs.reset();

                        this.$emit("dialog:change", "editar");


                        // this.close()
                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    // guardar
                    try {

                        const request = {
                            employee_id: this.editedItem.employee_id,
                            salary_type_id: this.editedItem.salary_type_id,
                            salary: this.editedItem.salary,
                            position_array: this.editedItem.position_array
                        }

                        console.log(request, ' ---  QQQQQQQ')
                        const response = await this.$store.dispatch("employee/REGISTER_SALARY", request);

                        this.$refs.obs.reset();

                        this.$emit("dialog:change", "registro");
                    } catch (error) {
                        console.log(error, 'QQQQQQQ')
                    }
                    // this.close()
                }
            },


        },
    }
</script>
