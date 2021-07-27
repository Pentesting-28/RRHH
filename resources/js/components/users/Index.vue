<template>
  <v-container>
    <v-row>
        <v-col>
          <v-card class="shadow-large round">
            <v-data-table
              :headers="headers"
              :items="ItemsUsers"
              sort-by="calories"
              class="elevation-0">
              <template v-slot:top>
                <v-toolbar flat color="transparent" class="round">
                    <v-toolbar-title>Users</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="700px">
                    <template v-slot:activator="{ on }">
                      <v-btn
                        rounded    
                        flat                  
                        color="#064b6df0"
                        dark
                        class="mb-2 shadow-small"
                        v-on="on"
                      >
                          <v-icon class="mr-3">mdi-account-plus</v-icon>
                          New User
                      </v-btn>
                    </template>
                    <ValidationObserver tag="form" v-slot="{ passes }">
                      <v-card>
                        <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                          <v-container>
                              <v-row>
                                <v-col cols="12" sm="12" md="4">
                                  <ValidationProvider name="name" rules="required" v-slot="{ errors }">
                                    <v-text-field
                                        dense
                                        outlined
                                        v-model="editedItem.name"
                                        label="Nombre"
                                        :error-messages="errors">
                                    </v-text-field>
                                  </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="12" md="8">
                                  <ValidationProvider name="email" rules="email|required" v-slot="{ errors }">
                                    <v-text-field
                                        dense
                                        outlined
                                        v-model="editedItem.email"
                                        label="Email"
                                        :error-messages="errors">
                                    </v-text-field>
                                  </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="12" md="4" v-if='edit === false'>
                                  <ValidationProvider name="password" rules="confirmed:confirmation|required" v-slot="{ errors }">
                                    <v-text-field
                                        dense
                                        outlined
                                        v-model="password"
                                        label="Contraseña"
                                        type="password"
                                        :error-messages="errors">
                                    </v-text-field>
                                  </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="12" md="4" v-if='edit === false'>
                                  <ValidationProvider name="confirm password" rules="required" vid="confirmation" v-slot="{ errors }">
                                    <v-text-field
                                        dense
                                        outlined
                                        v-model="confirm_password"
                                        label="Confirmación de Contraseña"
                                        type="password"
                                        :error-messages="errors">
                                    </v-text-field>
                                  </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="12" md="4">
                                  <ValidationProvider name="role" rules="required" v-slot="{ errors }">
                                    <v-select
                                      dense
                                      outlined
                                      v-model="editedItem.rol"
                                      label="Rol"
                                      :items="ItemsRol"
                                      item-text="name"
                                      item-value="id"
                                      :error-messages="errors"
                                      >
                                    </v-select>
                                  </ValidationProvider>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                  <ValidationProvider name="permission" rules="required" v-slot="{ errors }">
                                    <v-autocomplete
                                      v-model="editedItem.permission"
                                      :items="ItemsPermissions"
                                      item-text="name"
                                      item-value="id"
                                      outlined
                                      dense
                                      chips
                                      small-chips
                                      label="Permisos"
                                      multiple
                                    ></v-autocomplete>
                                  </ValidationProvider>
                                </v-col>

                              </v-row>
                          </v-container>
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn outlined @click="close">Cancel</v-btn>
                          <v-btn color="#E63E59" outlined @click="passes(save)">Save</v-btn>
                        </v-card-actions>
                      </v-card>
                    </ValidationObserver>
                    </v-dialog>
                </v-toolbar>
              </template>
              <template v-slot:item.action="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-account-edit
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-account-remove
                </v-icon>
                <v-icon
                    small
                    @click="dialog_password_t(item)"
                >
                    mdi-lock
                </v-icon>
              </template>
              <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
              </template>
            </v-data-table>
          </v-card>
        </v-col>
    </v-row>
    <v-row justify="center">
      <v-dialog v-model="dialog_password" persistent max-width="300">
        <ValidationObserver tag="form" v-slot="{ passes }">
        <v-card>
          <v-card-title class="headline">Cambiar contraseña de usuario</v-card-title>
          <v-card-text>
            <ValidationProvider name="password" rules="confirmed:confirmation|required|min:8" v-slot="{ errors }">
              <v-text-field
                  dense
                  outlined
                  v-model="password_1"
                  label="Contraseña"
                  type="password"
                  :error-messages="errors">
              </v-text-field>
            </ValidationProvider>
            <ValidationProvider name="confirm password" rules="required|min:8" vid="confirmation" v-slot="{ errors }">
              <v-text-field
                dense
                outlined
                v-model="password_2"
                label="Nueva Contraseña"
                type="password"
                :error-messages="errors"
              ></v-text-field>
            </ValidationProvider>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="passes(save_password)">Aceptar</v-btn>
            <v-btn color="green darken-1" text @click="dialog_password = false">Cancelar</v-btn>
          </v-card-actions>
        </v-card>
        </ValidationObserver>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
  import Swal from 'sweetalert2';

  export default {
    data: () => ({
    password_1: '',
    password_2: '',
    dialog_password: false,
    edit: false,
    position_array: '',
    id_user: 0,
    itemsPerPage: 10,
      dialog: false,
      headers: [
        { text: 'Name', align: 'left', sortable: false, value: 'name', class: 'length_text'},
        { text: 'Email', value: 'email', class: 'length_text' },
        { text: 'Role', value: 'role.name', class: 'length_text' },
        { text: 'Actions', value: 'action', sortable: false, class: 'length_text' },
      ],
      desserts: [],
      editedIndex: -1,
      password: '',
      confirm_password: '',
        enable: true,
      editedItem: {
        name: '',
        email: '',
        rol: '',
        permission: []
      },
      defaultItem: {
        name: '',
        email: '',
        rol: '',
        permission: []
      },
    }),

    computed: {
      formTitle () {
        return this.edit === false ? 'Nuevo usuario' : 'Editar Usuario'
      },
      ItemsRol() {
        return this.$store.getters["users/GET_ROL"];
      },

      ItemsPermissions() {
        return this.$store.getters["users/GET_PERMISSION"];
      },
      ItemsUsers() {
        return this.$store.getters["users/GET_USERS"];
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize();
      this.role();
      this.permission();
    },

    methods: {

      async permission () {
        try {
          const response = await this.$store.dispatch("users/INDEX_PERMISSION");
          console.log(response.data,'permission_id')
        } catch (error) {
          console.log(error);
        }
      },

      async initialize () {
        try {
          const response = await this.$store.dispatch("users/INDEX_USER");
          console.log(response.data,'PAGINADOS')
        } catch (error) {
          console.log(error);
        }
      },

      editItem (item) {
        console.log(item,'editar')
            // let data = state.users.indexOf(payload)
        this.position_array = this.ItemsUsers.indexOf(item)
        console.log(this.position_array,'updated position')

        this.edit = true;
        this.id_user = item.id
        // this.editedIndex = this.desserts.indexOf(item)
        // this.editedItem = Object.assign({}, item)
        this.editedItem.name = item.name
        this.editedItem.email = item.email
        this.editedItem.rol = item.role.id

        this.editedItem.permission = item.permission.map((index, elem) => {
                            return index.id;
                          })
        // this.editedItem.permission = item.permissions
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },

      close () {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          this.edit = false;
        }, 300)
      },

      async save () {
        //   editar
        if (this.edit === true) {
        //   Object.assign(this.desserts[this.editedIndex], this.editedItem)
          this.editedItem.permission.push(1)
          const request = {
            id: this.id_user,
            name: this.editedItem.name,
            email: this.editedItem.email,
            role_id: this.editedItem.rol,
            permissions: this.editedItem.permission,
            position_array: this.position_array
          }
          console.log(request,'****  editar ****')
          try {
            const response = await this.$store.dispatch("users/UPDATED_USER", request);
            console.log(response);
          } catch (error) {
            console.log(error);
          }
        } else {
        // guardar
        //   this.desserts.push(this.editedItem)
          const request = {
            password: this.password,
            password_confirmation: this.confirm_password,
            name: this.editedItem.name,
            email: this.editedItem.email,
            role_id: this.editedItem.rol,
            permissions: this.editedItem.permission
          }

          console.log(request,'guardar')
          try {
            const response = await this.$store.dispatch("users/REGISTER_USER", request);
            console.log(response,'registro con exito');
          } catch (error) {
            console.log(error);
          }
        }
        this.close()
      },

      async role() {
        try {
          const response = await this.$store.dispatch("users/ROL_USER");
        } catch (error) {
          console.log(error);
        }
      },
      dialog_password_t(item) {
        this.id_user = item.id
        this.dialog_password = true
      },
      async save_password() {
        try {
        const request = {
          id: this.id_user,
          password: this.password_1,
          password_confirmation: this.password_2,
        }
          const response = await this.$store.dispatch("users/PASSWORD", request);
          this.id_user = ''
          this.password_1 = ''
          this.password_2 = ''
          this.dialog_password = false
          Swal.fire({
              icon: 'success',
              title: 'Contraseña actualizada con exito',
            })
        } catch (error) {
          console.log(error.response.data);
          Swal.fire({
              icon: 'error',
              title: error.response.data.message,
            })
        }
      }
    },
  }
</script>

<style>
.length_text {
  font-size: 1rem !important
}
</style>
