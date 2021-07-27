<template>
    <v-dialog v-model="active" max-width="600px" persistent>

        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                <v-card-text>
                    <v-container>
                            <v-row>
                                <v-col cols="12" sm="6">
                                    <ValidationProvider
                                      name="Acreedores"
                                      rules="required"
                                      v-slot="{ errors }"
                                    >
                                      <v-autocomplete
                                        v-model="editedItem.creditor_id"
                                        :items="ItemsCreditor"
                                        item-text="name"
                                        item-value="id"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        label="Acreedores"
                                        :error-messages="errors"
                                      ></v-autocomplete>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <ValidationProvider
                                      name="Tipo de gasto"
                                      rules="required"
                                      v-slot="{ errors }"
                                    >
                                      <v-autocomplete
                                        v-model="editedItem.type_expense_id"
                                        :items="ItemsTypeExpense"
                                        item-text="name"
                                        item-value="id"
                                        outlined
                                        dense
                                        chips
                                        small-chips
                                        label="Tipo de gasto"
                                        :error-messages="errors"
                                      ></v-autocomplete>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6" v-if="editedItem.creditor_id == 1">
                                    <ValidationProvider name="name" :rules="{required:(editedItem.creditor_id > 1) ? true : false}" v-slot="{ errors }">
                                        <v-text-field
                                            v-model="editedItem.name"
                                            label="Nombre"
                                            outlined
                                            dense
                                            :error-messages="errors">
                                        </v-text-field>
                                    </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <ValidationProvider name="cantidad" rules="required" v-slot="{ errors }">
                                        <v-text-field
                                            prefix="$"
                                            type="number"
                                            :hint="currencyFormat(editedItem.quantity)"
                                            v-model="editedItem.quantity"
                                            label="Cantidad"
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
        props: ["active", "editedItem", "edit"],

        data: () => ({
            snackbar: false,
            text: '',
            loading: false,
            menu1: false,
            menu2: false,
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
                email: '',
                rol: '',
                // permission: []
            },
        }),

        computed: {
            formTitle() {
                return this.edit === false ? 'Nuevo Modulo Acreedors' : 'Editar Modulo Acreedors'
            },
            ItemsCreditor() {
                return this.$store.getters["creditor/GET_CREDITOR"];
            },
            ItemsTypeExpense() {
                return this.$store.getters["type_expense/GET_TYPE_EXPENSE"];
            },
            // status: {
            //     get () {
            //         return (this.editedItem.status === 1) ? true : false
            //     },
            //     set (val) {
            //         this.editedItem.status = val
            //     }
            // }
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
        },

        created() {
            // this.initialize();
            //this.ruc_type();
        },

        methods: {

            async save1() {
                this.e1 = 2
            },

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
                this.$emit("dialog:change", "cerrar");
            },


            async save() {
                //   editar
                if (this.edit === true) {
                    //   Object.assign(this.desserts[this.editedIndex], this.editedItem)
                    const request = {
                        id: this.editedItem.id,
                        name: this.editedItem.name,
                        quantity: this.editedItem.quantity,
                        creditor_id: this.editedItem.creditor_id,
                        type_expense_id: this.editedItem.type_expense_id,
                        employee_id: this.editedItem.employee_id,
                        position_array: this.editedItem.position_array
                    }

                    console.log(request, 'editar')
                    try {
                        const response = await this.$store.dispatch("module_creditor/UPDATED", request);
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
                            name: this.editedItem.name,
                            quantity: this.editedItem.quantity,
                            creditor_id: this.editedItem.creditor_id,
                            type_expense_id: this.editedItem.type_expense_id,
                            employee_id: this.editedItem.employee_id,
                        }

                        const response = await this.$store.dispatch("module_creditor/REGISTER", request);

                        this.$refs.obs.reset();

                        this.$emit("dialog:change", "registro");

                        console.log(response, 'registro con exito');
                        // Swal.fire({
                        //   icon: 'success',
                        //   title: 'Empresa creada con exito',
                        // })
                        // this.close()
                    } catch (error) {
                        // console.log(error.response, 'QQQQQQQ')

                        let e = error.response.data.message;
                        // console.log(e, "error");
                        let list = "";

                        for (const prop in e) {
                          // console.log(prop, "ptop");
                          list = list + `<li>${e[prop][0]}</li>`;
                        }

                        Swal.fire({
                          icon: "error",
                          title: "Oops...",
                          html: list
                        });
                    }
                    // this.close()
                }
            },
        },
    }
</script>
