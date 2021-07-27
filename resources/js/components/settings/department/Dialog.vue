<template>
    <v-dialog v-model="active" max-width="400px" persistent>

        <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
                <v-container>
                    <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                        <v-row>
                            <v-col cols="12" sm="12">
                                <ValidationProvider name="name" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.name"
                                        label="Nombre"
                                        outlined
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12">
                                <ValidationProvider name="description" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.description"
                                        label="Descripcion"
                                        outlined
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12">
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
                return this.edit === false ? 'Nuevo Departamento' : 'Editar Departamento'
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
                        position_array: this.editedItem.position_array
                    }

                    console.log(request, 'editar')
                    try {
                        const response = await this.$store.dispatch("department/UPDATED", request);
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
                            name: this.editedItem.name
                        }

                        const response = await this.$store.dispatch("department/REGISTER", request);

                        this.$refs.obs.reset();

                        this.$emit("dialog:change", "registro");

                        console.log(response, 'registro con exito');
                        // Swal.fire({
                        //   icon: 'success',
                        //   title: 'Empresa creada con exito',
                        // })
                        // this.close()
                    } catch (error) {
                        console.log(error, 'QQQQQQQ')
                    }
                    // this.close()
                }
            },
        },
    }
</script>
