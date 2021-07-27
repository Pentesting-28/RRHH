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
                            <!-- <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="number" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        v-model="editedItem.number"
                                        label="Numero"
                                        outlined
                                        dense
                                        disabled
                                        :error-messages="errors">
                                    </v-text-field>
                                </ValidationProvider>
                            </v-col>  -->

                            <v-col cols="12" sm="12" md="4">
                              <v-menu
                                v-model="menu2"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                              >
                                  <template v-slot:activator="{ on }">
                                    <ValidationProvider name="expiration" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                      v-model="editedItem.expiration"
                                      label="Fecha de Expiración"
                                      readonly
                                      outlined
                                      dense
                                      v-on="on"
                                      :error-messages="errors"
                                    ></v-text-field>
                                    </ValidationProvider>
                                  </template>
                                <v-date-picker v-model="editedItem.expiration" @input="menu2 = false" no-title></v-date-picker>
                              </v-menu>
                            </v-col>

                            <v-col cols="12" sm="12" md="4">
                                <ValidationProvider name="status_dni" rules="required" v-slot="{ errors }">
                                    <v-autocomplete
                                      v-model="editedItem.status_dni"
                                      :items="ItemsDNI"
                                      outlined
                                      dense
                                      chips
                                      small-chips
                                      label="Estatus"
                                      :error-messages="errors"
                                    ></v-autocomplete>
                                </ValidationProvider>
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                    <ValidationProvider name="photo_dni" v-slot="{ errors }">
                                        <v-file-input
                                          outlined
                                          dense
                                          show-size
                                          v-model="editedItem.photo_dni"
                                          @change="onFileSelected"
                                          accept=".jpg,.png"
                                          label="Foto dni"
                                          :error-messages="errors"
                                        ></v-file-input>
                                    </ValidationProvider>         
                            </v-col>
                            <v-col cols="12" sm="12" md="6">
                                <v-expand-x-transition>
                                    <v-col cols="12" v-if="img_expand">
                                        <v-img
                                          :src="img_preview"
                                          alt="foto dni"
                                          aspect-ratio="2"
                                          dark
                                        >
                                        </v-img>
                                    </v-col>
                                    <v-col cols="12" v-if="typeof editedItem.photo_dni == 'string'">
                                        <v-img
                                          :src="editedItem.photo_dni"
                                          alt="foto licencia"
                                          aspect-ratio="2"
                                          dark
                                          @click="dialogZoom(editedItem.photo_dni,'Foto dni')"
                                        >
                                        </v-img>
                                    </v-col>
                                </v-expand-x-transition>
                            </v-col>

                            <!-- <v-col cols="12">
                                <ValidationProvider name="observation"  v-slot="{ errors }">
                                    <v-textarea
                                        v-model="editedItem.observation"
                                        label="Observaciones"
                                        outlined
                                        dense
                                        :error-messages="errors">
                                    </v-textarea>
                                </ValidationProvider>
                            </v-col> -->

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
        <!-- zoom foto -->
        <v-dialog v-model="dialog3" max-width="600px">
            <v-card>
                <v-card-title>
                <span>{{name_photo}}</span>
                <v-spacer></v-spacer>
                </v-card-title>
                <v-card-text>
                <v-img :src="url_image"></v-img>
                </v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="dialog3 = false">Cerrar</v-btn>
                <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-dialog>
</template>
<script>
    import Swal from 'sweetalert2';

    export default {
        props: ["active", "editedItem", "edit", "employee_id"],

        data: () => ({
            dialog3: false,
            name_photo: '',
            url_image: '',
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
            ItemsDNI:['activa', 'vencida', 'perdida', 'robada', 'otro']
        }),

        computed: {
            formTitle() {
                return this.edit === false ? 'Nueva DNI' : 'Editar DNI'
            },
            ItemsLicense() {
              return this.$store.getters["employee/GET_LICENSE_TYPE"];
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
                // formData.append("observation", this.editedItem.observation);
                formData.append("photo_dni", this.editedItem.photo_dni);
                formData.append("expiration", this.editedItem.expiration);
                formData.append("status_dni", this.editedItem.status_dni);
                // formData.append("license_letter_id", this.editedItem.license_letter_id);

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
                        const response = await this.$store.dispatch("driving_license/UPDATED_DNI", request);
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

                        const response = await this.$store.dispatch("driving_license/REGISTER_DNI", request);

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

            dialogZoom(url, title) {
                this.dialog3 = true;
                this.name_photo = title;
                this.url_image = url;
            },

           
        },
    }
</script>
