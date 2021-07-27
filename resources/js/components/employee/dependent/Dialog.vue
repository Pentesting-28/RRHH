<template>
    <v-dialog v-model="active" max-width="1000px" persistent>

        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
                <v-container>
                    <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                        <v-row>
                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="name" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.name"
                                        label="Nombre"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="last_name" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.last_name"
                                        label="Apellido"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="dni" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.dni"
                                        label="Cedula"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="relationship" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.relationship"
                                        label="Parentezco"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="age" rules="required|numeric" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.age"
                                        label="Edad"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>



                            <v-col cols="12" sm="12" md="6">
                                <v-btn
                                    color="primary"
                                    @click="passes(save)">
                                    Guardar
                                </v-btn>

                                <v-btn text @click="close">Cancelar</v-btn>
                            </v-col>
                        </v-row>
                    </ValidationObserver>
                </v-container>
            </v-card-text>


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
                return this.edit === false ? 'Nuevo Perentezco' : 'Editar Parentezco'
            }
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
        },

        methods: {

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
                        name: this.editedItem.name,
                        last_name: this.editedItem.last_name,
                        dni: this.editedItem.dni,
                        relationship: this.editedItem.relationship,
                        age: this.editedItem.age,
                        position_array: this.editedItem.position_array
                    }

                    console.log(request, 'editar')
                    try {
                        const response = await this.$store.dispatch("employee/UPDATED_DEPENDENT", request);
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
                            name: this.editedItem.name,
                            last_name: this.editedItem.last_name,
                            dni: this.editedItem.dni,
                            relationship: this.editedItem.relationship,
                            age: this.editedItem.age,
                            position_array: this.editedItem.position_array
                        }

                        console.log(request, ' ---  QQQQQQQ')
                        const response = await this.$store.dispatch("employee/REGISTER_DEPENDENT", request);

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
