<template>
  <div>
    <v-dialog
      v-model="active"
      persistent
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>

        <v-card-text>
          <template>
            <v-stepper v-model="e1" class="elevation-0">
              <v-stepper-header class="elevation-0">
                <v-stepper-step :complete="e1 > 1" step="1">Personales</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="e1 > 2" step="2">Contacto</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="e1 > 3" step="3">Dirección</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="e1 > 4" step="4">Familiares</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="e1 > 5" step="5">Medicos</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="e1 > 6" step="6">Cargo</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="7">Finalización de contrato</v-stepper-step>
              </v-stepper-header>

              <v-stepper-items>
                <!-- datos personales -->
                <v-stepper-content step="1">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Primer Nombre"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.name"
                                label="Primer Nombre"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Segundo nombre" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.middle_name"
                                label="Segundo nombre"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Primer Apellido"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.last_name"
                                label="Primer Apellido"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Segundo Apellido" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.second_surname"
                                label="Segundo Apellido"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Fecha de Nacimiento" v-slot="{ errors }">
                              <v-menu
                                v-model="menu_birth"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                              >
                                <template v-slot:activator="{ on }">
                                  <v-text-field
                                    v-model="editedItem.date_birth"
                                    label="Fecha de Nacimiento"
                                    readonly
                                    outlined
                                    dense
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  v-model="editedItem.date_birth"
                                  @input="menu_birth = false"
                                  no-title
                                ></v-date-picker>
                              </v-menu>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Edad" rules="numeric" v-slot="{ errors }">
                              <v-text-field
                                type="number"
                                v-model="editedItem.age"
                                label="Edad"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Cedula" rules="required" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.dni"
                                label="Cedula"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Estado Civil"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.status_marital_id"
                                :items="ItemsStatusMarital"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Estado Civil"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Seguro Social"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.social_security"
                                label="Seguro Social"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <!-- <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Foto de cedula" v-slot="{ errors }">
                              <v-file-input
                                outlined
                                dense
                                show-size
                                v-model="editedItem.photo_dni"
                                @change="onFileSelected"
                                accept=".jpg, .png"
                                label="Foto de cedula"
                                :error-messages="errors"
                              ></v-file-input>
                            </ValidationProvider>
                            <v-expand-x-transition>
                              <v-col cols="12" v-if="img_expand">
                                <v-img
                                  :src="img_preview_dni"
                                  alt="foto cedula"
                                  aspect-ratio="2"
                                  dark
                                ></v-img>
                              </v-col>
                              <v-col cols="12" v-if="typeof editedItem.photo_dni == 'string'">
                                <v-img
                                  :src="editedItem.photo_dni"
                                  alt="foto cedula"
                                  aspect-ratio="2"
                                  dark
                                  @click="dialogZoom(editedItem.photo_dni,'Foto de cedula')"
                                ></v-img>
                              </v-col>
                            </v-expand-x-transition>
                          </v-col> -->

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Foto" v-slot="{ errors }">
                              <v-file-input
                                outlined
                                dense
                                show-size
                                v-model="editedItem.photo"
                                @change="onFilePhoto"
                                accept=".jpg, .png"
                                label="Foto"
                                :error-messages="errors"
                              ></v-file-input>
                            </ValidationProvider>
                            <v-expand-x-transition>
                              <v-col cols="12" v-if="img_expand_1">
                                <v-img
                                  :src="img_preview_employee"
                                  alt="foto empleado"
                                  aspect-ratio="2"
                                  dark
                                ></v-img>
                              </v-col>
                              <v-col cols="12" v-if="typeof editedItem.photo == 'string'">
                                <v-img
                                  :src="editedItem.photo"
                                  alt="foto empleado"
                                  aspect-ratio="2"
                                  dark
                                  @click="dialogZoom(editedItem.photo,'Foto de empleado')"
                                ></v-img>
                              </v-col>
                            </v-expand-x-transition>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>
                    <v-btn color="primary" @click="passes(save1)">Continuar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
                <!-- contacto -->
                <v-stepper-content step="2">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="12" md="3">
                            <ValidationProvider name="Telefono Local" rules v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.contact.tlf_home"
                                label="Telefono Local"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="3">
                            <ValidationProvider
                              name="Telefono Movil"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.contact.tlf_movil"
                                label="Telefono Movil"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <!--  <v-col cols="12" sm="12" md="4">
                                    <ValidationProvider name="Telefono Emergencia" v-slot="{ errors }">
                                        <v-text-field
                                            v-model="editedItem.contact.tlf_other"
                                            label="Telefono Emergencia"
                                            outlined
                                            dense
                                            :error-messages="errors">
                                        </v-text-field>
                                    </ValidationProvider>
                          </v-col>-->

                          <v-col cols="12" sm="12" md="6">
                            <ValidationProvider name="Email" rules="email" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.contact.email"
                                label="Email"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>
                    <v-btn color="primary" @click="passes(save2)">Continuar</v-btn>

                    <v-btn color="secondary" @click="e1 = 1">Regresar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
                <!-- direccion -->
                <v-stepper-content step="3">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Dirección"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.address.name"
                                label="Dirección"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Posee Carro"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.address.status_car"
                                :items="ItemsOption"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Posee Carro"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Licencia de conducir"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.address.car.driver_license"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Licencia de conducir"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.address.status_car == 'Si'"
                          >
                            <ValidationProvider
                              name="Marca"
                              :rules="{required: (editedItem.address.status_car == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.address.car.brand"
                                label="Marca"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.address.status_car == 'Si'"
                          >
                            <ValidationProvider
                              name="Modelo"
                              :rules="{required: (editedItem.address.status_car == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.address.car.model"
                                label="Modelo"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.address.status_car == 'Si'"
                          >
                            <ValidationProvider
                              name="Placa"
                              :rules="{required: (editedItem.address.status_car == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.address.car.license_plate"
                                label="Placa"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>
                    <v-btn color="primary" @click="passes(save3)">Continuar</v-btn>

                    <v-btn color="secondary" @click="e1 = 2">Regresar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
                <!-- datos familiares -->
                <v-stepper-content step="4">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Nombre del padre" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.dependent.name_father"
                                label="Nombre del padre"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Nombre de la madre" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.dependent.name_mother"
                                label="Nombre de la madre"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.status_marital_id == 5 || editedItem.status_marital_id == 2"
                          >
                            <ValidationProvider name="Nombre del conyuge" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.dependent.name_spouse"
                                label="Nombre del conyuge"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.status_marital_id == 5 || editedItem.status_marital_id == 2"
                          >
                            <ValidationProvider
                              name="Fecha de Nacimiento Esposo"
                              v-slot="{ errors }"
                            >
                              <v-menu
                                v-model="menu_spouse"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px"
                              >
                                <template v-slot:activator="{ on }">
                                  <v-text-field
                                    v-model="editedItem.dependent.date_spouse"
                                    label="Fecha de Nacimiento Esposo"
                                    readonly
                                    outlined
                                    dense
                                    v-on="on"
                                  ></v-text-field>
                                </template>
                                <v-date-picker
                                  v-model="editedItem.dependent.date_spouse"
                                  @input="menu_spouse = false"
                                  no-title
                                ></v-date-picker>
                              </v-menu>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.status_marital_id == 5 || editedItem.status_marital_id == 2"
                          >
                            <ValidationProvider
                              name="Lugar de trabajo del conyuge"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.dependent.spouse_job"
                                label="Lugar de trabajo del conyuge"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.status_marital_id == 5 || editedItem.status_marital_id == 2"
                          >
                            <ValidationProvider name="Posición del conyuge" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.dependent.spouse_position"
                                label="Posición del conyuge"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Tiene algun familiar que labore en la empresa ? en caso afirmativo, mencione nombre y parentesco"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.dependent.family_business"
                                label="Tiene algun familiar que labore en la empresa ? en caso afirmativo, mencione nombre y parentesco"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="En caso de urgencia notificar a"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.dependent.urgency_notify"
                                label="En caso de urgencia notificar a"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Parentesco"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.dependent.urgency_relationship"
                                label="Parentesco"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Telefono de residencia"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.dependent.urgency_res"
                                label="Telefono"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <!--  <v-col cols="12" sm="12" md="4">
                                    <ValidationProvider name="Telefono Oficina" v-slot="{ errors }">
                                      <v-text-field
                                        v-model="editedItem.dependent.urgency_office"
                                        label="Telefono Oficina"
                                        outlined
                                        dense
                                        :error-messages="errors"
                                      ></v-text-field>
                                    </ValidationProvider>
                          </v-col>-->

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Dirección"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.dependent.urgency_address"
                                label="Dirección"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="4" md="4">
                            <ValidationProvider
                              name="Tiene Dependientes"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.dependent.children_status"
                                :items="ItemsOption"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Tiene Dependientes"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-row v-if="editedItem.dependent.children_status == 'Si'">
                            <v-col cols="12">
                              <v-icon>mdi-account</v-icon>Datos de Dependientes
                              <v-divider></v-divider>
                            </v-col>
                            <v-col cols="12" sm="4" md="4">
                              <v-row>
                                <v-col cols="12">
                                  <v-text-field
                                    v-model="name"
                                    label="Nombre"
                                    outlined
                                    dense
                                    required
                                  ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                  <v-autocomplete
                                    v-model="relationship"
                                    :items="ItemsOptionRelationship"
                                    outlined
                                    dense
                                    chips
                                    small-chips
                                    label="Parentesco"
                                  ></v-autocomplete>
                                </v-col>
                                <v-col cols="12">
                                  <v-autocomplete
                                    v-model="dependent"
                                    :items="ItemsOption"
                                    outlined
                                    dense
                                    chips
                                    small-chips
                                    label="Dependiente"
                                  ></v-autocomplete>
                                </v-col>
                                <v-col cols="12">
                                  <v-menu
                                    v-model="menu_children"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                  >
                                    <template v-slot:activator="{ on }">
                                      <v-text-field
                                        v-model="date"
                                        label="Fecha de Nacimiento"
                                        readonly
                                        outlined
                                        dense
                                        v-on="on"
                                      ></v-text-field>
                                    </template>
                                    <v-date-picker
                                      v-model="date"
                                      @input="menu_children = false"
                                      no-title
                                    ></v-date-picker>
                                  </v-menu>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                  <v-text-field v-model="age" label="Edad" outlined dense></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                  <v-autocomplete
                                    v-model="gender"
                                    :items="ItemsOptionGender"
                                    outlined
                                    dense
                                    chips
                                    small-chips
                                    label="Genero"
                                  ></v-autocomplete>
                                </v-col>

                                <v-btn dark color="#064b6df0" block @click="children_add()">Agregar</v-btn>
                              </v-row>
                            </v-col>
                            <v-col cols="12" sm="8" md="8">
                              <v-data-table
                                :headers="headers"
                                :items="editedItem.dependent.children"
                                :items-per-page="5"
                                class="elevation-0"
                              >
                                <template v-slot:item.action="{ item }">
                                  <v-icon
                                    small
                                    @click="children_edit_dialog(item,editedItem.dependent.children)"
                                  >mdi-account-edit</v-icon>
                                  <v-icon
                                    small
                                    @click="deleteItem(item,editedItem.dependent.children)"
                                  >mdi-account-remove</v-icon>
                                </template>
                              </v-data-table>
                            </v-col>
                          </v-row>
                        </v-row>
                      </v-container>
                    </v-card>
                    <v-btn color="primary" @click="passes(save4)">Continuar</v-btn>

                    <v-btn color="secondary" @click="e1 = 3">Regresar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
                <!-- informacion medica -->
                <v-stepper-content step="5">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Estatura (metros)" rules v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.medical_information.height"
                                label="Estatura (metros)"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Peso (Libras)"
                              rules="numeric"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.weight"
                                label="Peso (Libras)"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Tipo de sangre"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.blood_type"
                                label="Tipo de sangre"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Donante" rules="required" v-slot="{ errors }">
                              <v-autocomplete
                                v-model="editedItem.medical_information.donor"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Donante"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Hospitalizado"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.hospitalized"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Hospitalizado"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.medical_information.hospitalized == 'Si'"
                          >
                            <ValidationProvider
                              name="Explique"
                              :rules="{required: (editedItem.medical_information.hospitalized == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.hospitalized_explain"
                                label="Explique"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="A sufrido alguna de las siguientes enfermedades"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.disease"
                                :items="ItemsDisease"
                                outlined
                                dense
                                chips
                                small-chips
                                multiple
                                label="A sufrido alguna de las siguientes enfermedades"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="disease(editedItem.medical_information.disease) == 1"
                          >
                            <ValidationProvider
                              name="Explique"
                              :rules="{required: ( disease(editedItem.medical_information.disease) == 1) ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.disease_explain"
                                label="Explique"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Esta bajo tratamiento médicoo sufre algun impedimento fisico"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.treatment"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Esta bajo tratamiento médicoo sufre algun impedimento fisico"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.medical_information.treatment == 'Si'"
                          >
                            <ValidationProvider
                              name="Explique"
                              :rules="{required: (editedItem.medical_information.treatment == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.treatment_explain"
                                label="Explique"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Es alergico"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.allergic"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Es alergico"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.medical_information.allergic == 'Si'"
                          >
                            <ValidationProvider
                              name="Indique a cuales sustancias"
                              :rules="{required: (editedItem.medical_information.allergic == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.allergic_explain"
                                label="Indique a cuales sustancias"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Usa lentes"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.lenses"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Usa lentes"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Tiene buena audición"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.hearing"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Tiene buena audición"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Ha estado en tratamiento por drogas ?"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.drugs"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Ha estado en tratamiento por drogas ?"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.medical_information.drugs == 'Si'"
                          >
                            <ValidationProvider
                              name="Explique"
                              :rules="{required: (editedItem.medical_information.drugs == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.drugs_explain"
                                label="Explique"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Tiene algun familiar con problemas psiquiatricos o nerviosos"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.medical_information.psychiatric"
                                :items="ItemsOption"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Tiene algun familiar con problemas psiquiatricos o nerviosos"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col
                            cols="12"
                            sm="12"
                            md="4"
                            v-if="editedItem.medical_information.psychiatric == 'Si'"
                          >
                            <ValidationProvider
                              name="Quién"
                              :rules="{required: (editedItem.medical_information.psychiatric == 'Si') ? true : false }"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.medical_information.psychiatric_explain"
                                label="Quién"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>
                    <v-btn color="primary" @click="passes(save5)">Continuar</v-btn>

                    <v-btn color="secondary" @click="e1 = 4">Regresar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
                <!-- datos del cargo -->
                <v-stepper-content step="6">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs1">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Posicion"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.occupation_data.position_id"
                                :items="ItemsPosition"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Posicion"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Tipo de contrato"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.occupation_data.contract_type_id"
                                :items="ItemsContratType"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Tipo de contrato"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Estatus del empleado"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.occupation_data.status_employee_id"
                                :items="ItemsStatusEmployee"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Estatus del empleado"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

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
                                <ValidationProvider
                                  name="Inicio de contrato"
                                  rules="required"
                                  v-slot="{ errors }"
                                >
                                  <v-text-field
                                    v-model="editedItem.occupation_data.start_contract"
                                    label="Inicio de contrato"
                                    readonly
                                    outlined
                                    dense
                                    v-on="on"
                                    :error-messages="errors"
                                  ></v-text-field>
                                </ValidationProvider>
                              </template>
                              <v-date-picker
                                v-model="editedItem.occupation_data.start_contract"
                                @input="menu2 = false"
                                no-title
                              ></v-date-picker>
                            </v-menu>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <v-menu
                              v-model="menu1"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              transition="scale-transition"
                              offset-y
                              min-width="290px"
                            >
                              <template v-slot:activator="{ on }">
                                <ValidationProvider
                                  name="Tiempo probatorio"
                                  rules="required"
                                  v-slot="{ errors }"
                                >
                                  <v-text-field
                                    v-model="editedItem.occupation_data.probationary_period"
                                    label="Tiempo probatorio"
                                    readonly
                                    outlined
                                    dense
                                    v-on="on"
                                    :error-messages="errors"
                                  ></v-text-field>
                                </ValidationProvider>
                              </template>
                              <v-date-picker
                                v-model="editedItem.occupation_data.probationary_period"
                                @input="menu1 = false"
                                no-title
                              ></v-date-picker>
                            </v-menu>
                          </v-col>

                          <!-- <v-col cols="12" sm="12" md="4">
                                    <v-menu
                                      v-model="menu3"
                                      :close-on-content-click="false"
                                      :nudge-right="40"
                                      transition="scale-transition"
                                      offset-y
                                      min-width="290px"
                                    >
                                      <template v-slot:activator="{ on }">
                                        <ValidationProvider name="end_contract" 
                                          rules="required" 
                                          :rules="{required: (editedItem.occupation_data.contract_type_id == 1) ? true : false }" 
                                          v-slot="{ errors }">
                                          <v-text-field
                                            v-model="editedItem.occupation_data.end_contract"
                                            label="Finalizacion del contrato"
                                            readonly
                                            outlined
                                            dense
                                            v-on="on"
                                            :error-messages="errors"
                                          ></v-text-field>
                                        </ValidationProvider>
                                      </template>
                                      <v-date-picker v-model="editedItem.occupation_data.end_contract" @input="menu3 = false" no-title></v-date-picker>
                                    </v-menu>
                          </v-col>-->

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Metodo de pago"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.occupation_data.payment_method_id"
                                :items="ItemsPaymentMethods"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Metodo de pago"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Banco" rules="required" v-slot="{ errors }">
                              <v-autocomplete
                                v-model="editedItem.occupation_data.bank_id"
                                :items="ItemsBank"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Banco"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <!-- :rules="{required: (editedItem.occupation_data.bank_id > 0) ? true : false }"  -->
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Número de cuenta"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-text-field
                                v-model="editedItem.occupation_data.account_number"
                                label="Número de cuenta"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider
                              name="Departamento"
                              rules="required"
                              v-slot="{ errors }"
                            >
                              <v-autocomplete
                                v-model="editedItem.occupation_data.department_type_id"
                                :items="ItemsDepartament"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Departamento"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12">
                            <v-icon>mdi-tag</v-icon>Tallas de uniforme
                            <v-divider></v-divider>
                          </v-col>

                          <v-col cols="12" sm="12" md="3">
                            <ValidationProvider name="Camisa" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.occupation_data.shirt"
                                label="Camisa"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="3">
                            <ValidationProvider name="Pantalón" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.occupation_data.trousers"
                                label="Pantalón"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="3">
                            <ValidationProvider name="Vestido" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.occupation_data.dress"
                                label="Vestido"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>

                          <v-col cols="12" sm="12" md="3">
                            <ValidationProvider name="Calzado" v-slot="{ errors }">
                              <v-text-field
                                v-model="editedItem.occupation_data.footwear"
                                label="Calzado"
                                outlined
                                dense
                                :error-messages="errors"
                              ></v-text-field>
                            </ValidationProvider>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>

                    <v-btn color="primary" @click="passes(save6)" :loading="loading">Continuar</v-btn>

                    <v-btn color="secondary" @click="e1 = 5">Regresar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
                <!-- finalizacion del contrato -->
                <v-stepper-content step="7">
                  <ValidationObserver tag="form" v-slot="{ passes }" ref="obs1">
                    <v-card class="my-2 elevation-0" color="grey lighten-4">
                      <v-container>
                        <v-row>
                          <v-col cols="1" sm="1" md="1" class="pr-0">
                            <v-btn icon @click="editedItem.occupation_data.end_contract = ''">
                              <v-icon>mdi-reload</v-icon>
                            </v-btn>
                          </v-col>
                          <v-col cols="12" sm="12" md="4" class="pl-0">
                            <v-menu
                              v-model="menu3"
                              :close-on-content-click="false"
                              :nudge-right="40"
                              transition="scale-transition"
                              offset-y
                              min-width="290px"
                            >
                              <template v-slot:activator="{ on }">
                                <ValidationProvider
                                  name="Finalizacion del contrato"
                                  v-slot="{ errors }"
                                >
                                  <v-text-field
                                    v-model="editedItem.occupation_data.end_contract"
                                    label="Finalizacion del contrato"
                                    readonly
                                    outlined
                                    dense
                                    v-on="on"
                                    :error-messages="errors"
                                  ></v-text-field>
                                </ValidationProvider>
                              </template>
                              <v-date-picker
                                v-model="editedItem.occupation_data.end_contract"
                                @input="menu3 = false"
                                no-title
                              ></v-date-picker>
                            </v-menu>
                          </v-col>

                          <!-- :rules="{required: (editedItem.occupation_data.end_contract !== '') ? true : false }" -->
                          <v-col cols="12" sm="12" md="4">
                            <ValidationProvider name="Motivo" v-slot="{ errors }">
                              <v-autocomplete
                                v-model="editedItem.occupation_data.contract_termination_id"
                                :items="ItemsContractTermination"
                                item-text="name"
                                item-value="id"
                                outlined
                                dense
                                chips
                                small-chips
                                label="Motivo"
                                :error-messages="errors"
                              ></v-autocomplete>
                            </ValidationProvider>
                          </v-col>

                          <!-- :rules="{required: (editedItem.occupation_data.end_contract !== '') ? true : false }" -->
                          <v-col cols="12">
                            <ValidationProvider name="Razón">
                              <v-textarea
                                v-model="editedItem.occupation_data.end_your_contract"
                                outlined
                                label="Razón Despido"
                              ></v-textarea>
                            </ValidationProvider>
                          </v-col>
                        </v-row>
                      </v-container>
                    </v-card>

                    <v-btn color="primary" @click="passes(save)" :loading="loading">Guardar</v-btn>

                    <v-btn color="secondary" @click="e1 = 6">Regresar</v-btn>

                    <v-btn text @click="close">Cancelar</v-btn>
                  </ValidationObserver>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </template>
        </v-card-text>
      </v-card>
    </v-dialog>

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

    <!-- editar niños -->
    <v-dialog v-model="dialogChildren" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span>Editar Hijos</span>
          <v-spacer></v-spacer>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col cols="12" sm="6">
              <v-text-field v-model="update.name" label="Nombre del hijo" outlined dense required></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-autocomplete
                v-model="update.relationship"
                :items="ItemsOptionRelationship"
                outlined
                dense
                chips
                small-chips
                label="Parentesco"
              ></v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-autocomplete
                v-model="update.dependent"
                :items="ItemsOption"
                outlined
                dense
                chips
                small-chips
                label="Dependiente"
              ></v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-menu
                v-model="menu_children_edit"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="update.date"
                    label="Fecha de Nacimiento"
                    readonly
                    outlined
                    dense
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="update.date" @input="menu_children_edit = false" no-title></v-date-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-text-field v-model="update.age" label="Edad" outlined dense></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-autocomplete
                v-model="update.gender"
                :items="ItemsOptionGender"
                outlined
                dense
                chips
                small-chips
                label="Genero"
              ></v-autocomplete>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="children_edit()">Agregar</v-btn>
          <v-btn color="grey" @click="dialogChildren = false" dark>Cerrar</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import Swal from "sweetalert2";

export default {
  props: ["active", "editedItem", "edit"],

  data: () => ({
    update: {},
    position_children: null,
    dialogChildren: false,
    name_photo: "",
    url_image: "",
    dialog3: false,
    loading: false,
    img_preview_employee: "",
    img_preview_dni: "",
    img_expand: false,
    img_expand_1: false,
    name: "",
    dependent: "",
    relationship: "",
    date: "",
    age: "",
    gender: "",
    snackbar: false,
    text: "",
    loading: false,
    menu1: false,
    menu2: false,
    menu3: false,
    menu_spouse: false,
    menu_birth: false,
    menu_children: false,
    menu_children_edit: false,
    e1: 1,
    position_array: "",
    id_user: 0,
    itemsPerPage: 10,
    editedIndex: -1,
    password: "",
    files: [],
    confirm_password: "",
    defaultItem: {
      name: "",
      middle_name: "",
      last_name: "",
      second_surname: "",
      dni: "",
      position_id: "",
      contract_type: "",
      start_contract: "",
      probationary_period: "",
      end_contract: "",
      payment_method_id: "",
      department_type_id: "",
      // permission: []
    },
    ItemsStatusCard: [
      {
        id: 0,
        name: "No",
      },
      {
        id: 1,
        name: "Si",
      },
    ],
    headers: [
      {
        text: "Nombre de los dependientes",
        value: "name",
      },
      {
        text: "Parentesco",
        value: "relationship",
      },
      {
        text: "Dependientes",
        value: "dependent",
      },
      {
        text: "Fecha de nacimiento",
        value: "date",
      },
      {
        text: "Edad",
        value: "age",
      },
      {
        text: "Genero",
        value: "gender",
      },
      {
        text: "Acciones",
        value: "action",
      },
    ],
    children: [
      {
        name: "Frozen Yogurt",
        dependent: "si",
        date: "2020-10-10",
        age: 24,
        gender: "f",
      },
    ],
    ItemsDisease: [
      "Hipertensión",
      "Diabetes",
      "Asma",
      "Epilepsia",
      "Cancer",
      "Otra",
      "Ninguna",
    ],
    ItemsOption: ["Si", "No"],
    ItemsOptionGender: ["Femenino", "Masculino"],
    ItemsOptionRelationship: ["Mamá","Papá","Hija","Hijo"]
  }),

  computed: {
    formTitle() {
      return this.edit === false ? "Nuevo Empleado" : "Editar Empleado";
    },
    ItemsDepartament() {
      return this.$store.getters["employee/GET_DEPARTMENT_TYPES"];
    },
    ItemsPaymentMethods() {
      return this.$store.getters["employee/GET_PAYMENT_METHODS"];
    },
    ItemsPosition() {
      return this.$store.getters["employee/GET_POSITION"];
    },
    ItemsStatusMarital() {
      return this.$store.getters["employee/GET_STATUS_MARITAL"];
    },
    ItemsContratType() {
      return this.$store.getters["employee/GET_CONTRACT_TYPE"];
    },
    ItemsStatusEmployee() {
      return this.$store.getters["employee/GET_STATUS_EMPLOYEE"];
    },
    ItemsBank() {
      return this.$store.getters["bank/GET_BANK"];
    },
    ItemsContractTermination() {
      return this.$store.getters["employee/GET_CONTRACT_TERMINATION"];
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
      val || this.close();
    },
  },

  created() {
    if (this.editedItem.medical_information?.disease) {
      this.editedItem.medical_information.disease = JSON.parse(this.editedItem.medical_information.disease)
      
    }
  },

  methods: {
    disease(item) {
      if (item !== null) {
        if (item.length > 0) {
          if (item.includes("Otra")) {
            return 1;
          }
          return 0;
        }
        return 0;
      } else {
        return 0;
      }
    },

    deleteItem(item, children_array) {
      let position_array = children_array.indexOf(item);
      children_array.splice(position_array, 1);
      console.log(position_array);
    },

    children_edit_dialog(item, children_array) {
      this.dialogChildren = true;

      this.update = item
      // this.name = item.name;
      // this.dependent = item.dependent;
      // this.date = item.date;
      // this.age = item.age;
      // this.gender = item.gender;
      this.position_children = children_array.indexOf(item);
    },

    children_edit() {
      this.editedItem.dependent.children.splice(this.position_children, 1, this.update);
      this.dialogChildren = false;
    },

    children_add() {
      if (this.name !== "" && this.dependent !== "" && this.gender !== "" && this.relationship !== "") {
        const data = {
          name: this.name,
          dependent: this.dependent,
          date: this.date,
          age: this.age,
          gender: this.gender,
          relationship: this.relationship,
        };

        this.editedItem.dependent.children.push(data);

        this.name = "";
        this.dependent = "";
        this.date = "";
        this.age = "";
        this.gender = "";
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text:
            "Debe tener todos los datos completos, para registrar los hijos!",
        });
      }
    },

    save1() {
      this.e1 = 2;
    },
    save2() {
      this.e1 = 3;
    },
    save3() {
      this.e1 = 4;
    },
    save4() {
      this.e1 = 5;
    },
    save5() {
      this.e1 = 6;
    },
    save6() {
      this.e1 = 7;
    },

    close() {
      console.log('editedItem', this.editedItem)
      Swal.fire({
        title: "Esta seguro que desea cancelar?",
        text: "No podra revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#E53935",
        cancelButtonColor: "secondary",
        confirmButtonText: "Si",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          this.$emit("dialog:change", this.editedItem);
          Swal.fire({
            title: "Cancelado!",
            text: "Su formulario fue cancelado",
            icon: "success",
            confirmButtonColor: "#E53935",
          });
        }
      });
    },

    async save() {
      this.loading = true;
      //   editar
      let formData = new FormData();
      formData.append("photo_dni", this.editedItem.photo_dni);
      formData.append("photo", this.editedItem.photo);

      if (this.edit === true) {
        const request = [
          {
            id: this.editedItem.id,
            name: this.editedItem.name,
            middle_name: this.editedItem.middle_name,
            last_name: this.editedItem.last_name,
            second_surname: this.editedItem.second_surname,
            dni: this.editedItem.dni,
            // photo_dni: this.editedItem.photo_dni,
            // photo: this.editedItem.photo,
            status_marital_id: this.editedItem.status_marital_id,
            social_security: this.editedItem.social_security,
            date_birth: this.editedItem.date_birth,
            age: this.editedItem.age,
          },
          {
            tlf_home: this.editedItem.contact.tlf_home,
            tlf_movil: this.editedItem.contact.tlf_movil,
            email: this.editedItem.contact.email,
          },
          {
            name: this.editedItem.address.name,
            status_car: this.editedItem.address.status_car,
          },
          {
            brand: this.editedItem.address.car.brand,
            model: this.editedItem.address.car.model,
            license_plate: this.editedItem.address.car.license_plate,
            driver_license: this.editedItem.address.car.driver_license,
          },
          {
            name_father: this.editedItem.dependent.name_father,
            name_mother: this.editedItem.dependent.name_mother,
            name_spouse: this.editedItem.dependent.name_spouse,
            date_spouse: this.editedItem.dependent.date_spouse,
            spouse_job: this.editedItem.dependent.spouse_job,
            spouse_position: this.editedItem.dependent.spouse_position,
            family_business: this.editedItem.dependent.family_business,
            urgency_notify: this.editedItem.dependent.urgency_notify,
            urgency_relationship: this.editedItem.dependent
              .urgency_relationship,
            urgency_res: this.editedItem.dependent.urgency_res,
            // urgency_office: this.editedItem.dependent.urgency_office,
            urgency_address: this.editedItem.dependent.urgency_address,
            children_status: this.editedItem.dependent.children_status,
          },
          {
            children: this.editedItem.dependent.children,
          },
          {
            height: this.editedItem.medical_information.height,
            weight: this.editedItem.medical_information.weight,
            blood_type: this.editedItem.medical_information.blood_type,
            donor: this.editedItem.medical_information.donor,
            hospitalized: this.editedItem.medical_information.hospitalized,
            hospitalized_explain: this.editedItem.medical_information
              .hospitalized_explain,
            disease:
              this.editedItem.medical_information.disease == null
                ? ""
                : JSON.stringify(this.editedItem.medical_information.disease),
            disease_explain: this.editedItem.medical_information
              .disease_explain,
            treatment: this.editedItem.medical_information.treatment,
            treatment_explain: this.editedItem.medical_information
              .treatment_explain,
            allergic: this.editedItem.medical_information.allergic,
            allergic_explain: this.editedItem.medical_information
              .allergic_explain,
            lenses: this.editedItem.medical_information.lenses,
            hearing: this.editedItem.medical_information.hearing,
            drugs: this.editedItem.medical_information.drugs,
            drugs_explain: this.editedItem.medical_information.drugs_explain,
            psychiatric: this.editedItem.medical_information.psychiatric,
            psychiatric_explain: this.editedItem.medical_information
              .psychiatric_explain,
          },
          {
            position_id: this.editedItem.occupation_data.position_id,
            contract_type_id: this.editedItem.occupation_data.contract_type_id,
            status_employee_id: this.editedItem.occupation_data
              .status_employee_id,
            start_contract: this.editedItem.occupation_data.start_contract,
            probationary_period: this.editedItem.occupation_data
              .probationary_period,
            end_contract: this.editedItem.occupation_data.end_contract,
            payment_method_id: this.editedItem.occupation_data
              .payment_method_id,
            department_type_id: this.editedItem.occupation_data
              .department_type_id,
            bank_id: this.editedItem.occupation_data.bank_id,
            account_number: this.editedItem.occupation_data.account_number,
            shirt: this.editedItem.occupation_data.shirt,
            trousers: this.editedItem.occupation_data.trousers,
            dress: this.editedItem.occupation_data.dress,
            footwear: this.editedItem.occupation_data.footwear,
            contract_termination_id: this.editedItem.occupation_data
              .contract_termination_id,
            end_your_contract: this.editedItem.occupation_data
              .end_your_contract,
          },
        ];

        // let formData = new FormData();
        // formData.append("company_id", this.editedItem.id);
        // formData.append("p12", this.editedItem.files);

        console.log(request, "editar");
        try {
          const response = await this.$store.dispatch(
            "employee/UPDATED_EMPLOYEE",
            request
          );

          const request_1 = {
            id: this.editedItem.id,
            formData: formData,
            position_array: this.editedItem.position_array,
            page: this.editedItem.page,
          };

          const response_1 = await this.$store.dispatch(
            "employee/UPDATED_IMAGE_EMPLOYEE",
            request_1
          );

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
          const request = [
            {
              name: this.editedItem.name,
              middle_name: this.editedItem.middle_name,
              last_name: this.editedItem.last_name,
              second_surname: this.editedItem.second_surname,
              dni: this.editedItem.dni,
              // photo_dni: this.editedItem.photo_dni,
              // photo: this.editedItem.photo,
              status_marital_id: this.editedItem.status_marital_id,
              social_security: this.editedItem.social_security,
              date_birth: this.editedItem.date_birth,
              age: this.editedItem.age,
            },
            {
              tlf_home: this.editedItem.contact.tlf_home,
              tlf_movil: this.editedItem.contact.tlf_movil,
              tlf_other: this.editedItem.contact.tlf_other,
              email: this.editedItem.contact.email,
            },
            {
              name: this.editedItem.address.name,
              status_car: this.editedItem.address.status_car,
            },
            {
              brand: this.editedItem.address.car.brand,
              model: this.editedItem.address.car.model,
              license_plate: this.editedItem.address.car.license_plate,
              driver_license: this.editedItem.address.car.driver_license,
            },
            {
              name_father: this.editedItem.dependent.name_father,
              name_mother: this.editedItem.dependent.name_mother,
              name_spouse: this.editedItem.dependent.name_spouse,
              date_spouse: this.editedItem.dependent.date_spouse,
              spouse_job: this.editedItem.dependent.spouse_job,
              spouse_position: this.editedItem.dependent.spouse_position,
              family_business: this.editedItem.dependent.family_business,
              urgency_notify: this.editedItem.dependent.urgency_notify,
              urgency_relationship: this.editedItem.dependent
                .urgency_relationship,
              urgency_res: this.editedItem.dependent.urgency_res,
              // urgency_office: this.editedItem.dependent.urgency_office,
              urgency_address: this.editedItem.dependent.urgency_address,
              children_status: this.editedItem.dependent.children_status,
            },
            {
              children: this.editedItem.dependent.children,
            },
            {
              height: this.editedItem.medical_information.height,
              weight: this.editedItem.medical_information.weight,
              blood_type: this.editedItem.medical_information.blood_type,
              donor: this.editedItem.medical_information.donor,
              hospitalized: this.editedItem.medical_information.hospitalized,
              hospitalized_explain: this.editedItem.medical_information
                .hospitalized_explain,
              disease: JSON.stringify(this.editedItem.medical_information.disease),
              disease_explain: this.editedItem.medical_information
                .disease_explain,
              treatment: this.editedItem.medical_information.treatment,
              treatment_explain: this.editedItem.medical_information
                .treatment_explain,
              allergic: this.editedItem.medical_information.allergic,
              allergic_explain: this.editedItem.medical_information
                .allergic_explain,
              lenses: this.editedItem.medical_information.lenses,
              hearing: this.editedItem.medical_information.hearing,
              drugs: this.editedItem.medical_information.drugs,
              drugs_explain: this.editedItem.medical_information.drugs_explain,
              psychiatric: this.editedItem.medical_information.psychiatric,
              psychiatric_explain: this.editedItem.medical_information
                .psychiatric_explain,
            },
            {
              position_id: this.editedItem.occupation_data.position_id,
              contract_type_id: this.editedItem.occupation_data
                .contract_type_id,
              status_employee_id: this.editedItem.occupation_data
                .status_employee_id,
              start_contract: this.editedItem.occupation_data.start_contract,
              probationary_period: this.editedItem.occupation_data
                .probationary_period,
              end_contract: this.editedItem.occupation_data.end_contract,
              payment_method_id: this.editedItem.occupation_data
                .payment_method_id,
              department_type_id: this.editedItem.occupation_data
                .department_type_id,
              bank_id: this.editedItem.occupation_data.bank_id,
              account_number: this.editedItem.occupation_data.account_number,
              shirt: this.editedItem.occupation_data.shirt,
              trousers: this.editedItem.occupation_data.trousers,
              dress: this.editedItem.occupation_data.dress,
              footwear: this.editedItem.occupation_data.footwear,
              contract_termination_id: this.editedItem.occupation_data
                .contract_termination_id,
              end_your_contract: this.editedItem.occupation_data
                .end_your_contract,
            },
          ];

          const response = await this.$store.dispatch(
            "employee/REGISTER_EMPLOYEE",
            request
          );

          const request_1 = {
            id: response.data.id,
            formData: formData,
          };

          const response_1 = await this.$store.dispatch(
            "employee/REGISTER_IMAGE_EMPLOYEE",
            request_1
          );

          this.loading = false;

          this.$refs.obs.reset();

          this.$emit("dialog:change", "registro");
        } catch (error) {
          this.loading = false;

          console.log(error, "QQQQQQQ");
        }
        // this.close()
      }
    },

    onFileSelected(event) {
      // console.log(event);

      if (event === undefined) {
        this.img_expand = false;
        this.img_preview_dni = "";
        return;
      }
      const reader = new FileReader();

      // const imgtag = document.getElementById("photopreview");
      // imgtag.title = event.name;

      reader.onload = (readEvent) => {
        this.img_preview_dni = readEvent.target.result;
        this.img_expand = true;
      };

      reader.onerror = (event) => {
        console.warn(event);
        reader.abort();
      };

      reader.onabort = () => {
        this.img_preview_dni = "";
        this.img_expand = false;
      };

      reader.readAsDataURL(event);
    },

    onFilePhoto(event) {
      // console.log(event);

      if (event === undefined) {
        this.img_expand_1 = false;
        this.img_preview_employee = "";
        return;
      }
      const reader = new FileReader();

      // const imgtag = document.getElementById("photopreview");
      // imgtag.title = event.name;

      reader.onload = (readEvent) => {
        this.img_preview_employee = readEvent.target.result;
        this.img_expand_1 = true;
      };

      reader.onerror = (event) => {
        console.warn(event);
        reader.abort();
      };

      reader.onabort = () => {
        this.img_preview_employee = "";
        this.img_expand_1 = false;
      };

      reader.readAsDataURL(event);
    },

    dialogZoom(url, title) {
      this.dialog3 = true;
      this.name_photo = title;
      this.url_image = url;
    },
  },
};
</script>
