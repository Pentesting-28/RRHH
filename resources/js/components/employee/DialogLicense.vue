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
                                <ValidationProvider name="number" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.number"
                                        label="Numero"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col> 

                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="expiration" rules="required" v-slot="{ errors }">
                                    <v-menu
                                      v-model="menu2"
                                      :close-on-content-click="false"
                                      :nudge-right="40"
                                      transition="scale-transition"
                                      offset-y
                                      min-width="290px"
                                    >
                                      <template v-slot:activator="{ on }">
                                        <v-text-field
                                          v-model="editedItem.expiration"
                                          label="Fecha de Expiración"
                                          readonly
                                          outlined
                                          dense
                                          v-on="on"
                                        ></v-text-field>
                                      </template>
                                      <v-date-picker v-model="editedItem.expiration" @input="menu2 = false" no-title></v-date-picker>
                                    </v-menu>
                                </ValidationProvider>
                            </v-col>

                            <!-- <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="license_types_id" rules="required" v-slot="{ errors }">
                                    <v-autocomplete
                                      v-model="editedItem.license_types_id"
                                      :items="ItemsLicense"
                                      item-text="name"
                                      item-value="id"
                                      outlined
                                      dense
                                      chips
                                      small-chips
                                      label="Tipo de Licencia"
                                      :error-messages="errors"
                                    ></v-autocomplete>
                                </ValidationProvider>
                            </v-col> -->
                             <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="type_license_id" rules="required" v-slot="{ errors }">
                                    <v-autocomplete
                                      multiple
                                      v-model="editedItem.type_license_id"
                                      :items="ItemsLicenseLetter"
                                      item-text="name"
                                      item-value="id"
                                      outlined
                                      dense
                                      chips
                                      small-chips
                                      label="Letra de Licencia"
                                      :error-messages="errors"
                                    ></v-autocomplete>
                                </ValidationProvider>
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                    <ValidationProvider name="license_path" rules="required" v-slot="{ errors }">
                                        <v-file-input
                                          outlined
                                          dense
                                          show-size
                                          v-model="editedItem.license_path"
                                          @change="onFileSelected"
                                          accept=".jpg,.png"
                                          label="Foto de licencia"
                                          :error-messages="errors"
                                        ></v-file-input>
                                    </ValidationProvider>         
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                <v-expand-x-transition>
                                    <v-col cols="12" v-if="img_expand">
                                        <v-img
                                          :src="img_preview"
                                          alt="foto licencia"
                                          aspect-ratio="2"
                                          dark
                                        >
                                        </v-img>
                                    </v-col>
                                    <v-col cols="12" v-if="typeof editedItem.license_path == 'string'">
                                        <v-img
                                          :src="editedItem.license_path"
                                          alt="foto licencia"
                                          aspect-ratio="2"
                                          dark
                                        >
                                        </v-img>
                                    </v-col>
                                </v-expand-x-transition>
                            </v-col>

                            <v-col cols="12">
                                <ValidationProvider name="observation"  v-slot="{ errors }">
                                    <v-textarea
                                        v-model="editedItem.observation"
                                        label="Observaciones"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-textarea>
                                </ValidationProvider>
                            </v-col>

                            <v-col cols="12" sm="12" md="6">
                                <v-btn
                                    color="primary"
                                    :loading="loading"
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
            loading: false,
            img_preview: '',
            img_expand: false,
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
                middle_name: '',
                last_name: '',
                second_surname: '',
                dni: '',
                position_id: '',
                contract_type: '',
                start_contract: '',
                probationary_period: '',
                end_contract: '',
                payment_method_id: '',
                department_type_id: ''
                // permission: []
            },
        }),

        computed: {
            formTitle() {
                return this.edit === false ? 'Nueva Licencia' : 'Editar Licencia'
            },
            ItemsLicense() {
              return this.$store.getters["employee/GET_LICENSE_TYPE"];
            },
            ItemsLicenseLetter() {
              return this.$store.getters["employee/GET_LICENSE_LETTER"];
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

        methods: {

            close() {
                this.$emit("dialog:change", "cerrar_license");
            },

            onFileSelected(event) {
              // console.log(event);
              
              if (event === undefined) {
                  this.img_expand = false;
                  this.img_preview = '';
                  return;
              }
              const reader = new FileReader();

              // const imgtag = document.getElementById("photopreview");
              // imgtag.title = event.name;

              reader.onload = (readEvent) => {
                  this.img_preview = readEvent.target.result;
                  this.img_expand = true;
              };

              reader.onerror = (event) => {
                  console.warn(event);
                  reader.abort();
              }

              reader.onabort = () => {
                  this.img_preview = '';
                  this.img_expand = false;
              }

              reader.readAsDataURL(event);
            },


            async save() {
                this.loading = true;
                //   editar
                let formData = new FormData();
                formData.append("number", this.editedItem.number);
                formData.append("observation", this.editedItem.observation);
                formData.append("license_path", this.editedItem.license_path);
                formData.append("expiration", this.editedItem.expiration);
                formData.append("type_license_id", this.editedItem.type_license_id);

                console.log('licencia',formData)

                if (this.edit === true) {
                    //   Object.assign(this.desserts[this.editedIndex], this.editedItem)
                    formData.append("employee_id", this.editedItem.employee_id);


                    const request = {
                        id: this.editedItem.id,
                        formData: formData,                       
                        position_array: this.editedItem.position_array
                    }

                    console.log(request, 'editar')
                    try {
                        const response = await this.$store.dispatch("employee/UPDATED_LICENSE", request);
                        console.log(response);

                        this.loading = false;

                        this.$refs.obs.reset();

                        this.$emit("dialog:change", "editar");


                        // this.close()
                    } catch (error) {
                      this.loading = false;
                        console.log(error);
                    }
                } else {
                    // guardar
                    try {

                        formData.append("employee_id", this.employee_id);

                        const request = {
                           formData: formData,
                        }

                        const response = await this.$store.dispatch("employee/REGISTER_LICENSE", request);

                        this.loading = false;

                        this.$refs.obs.reset();

                        this.$emit("dialog:change", "registro");
                    } catch (error) {
                        this.loading = false;
                        console.log(error, 'QQQQQQQ')
                    }
                    // this.close()
                }
            },

           
        },
    }
</script>
