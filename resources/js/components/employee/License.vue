<template>
  <v-container>
    <v-row>
        <v-col>
          <v-card class="shadow-large round">
            <v-data-table
              :headers="headers"
              :items="ItemsLicense"
              class="elevation-0">
              <template v-slot:top>
                <v-toolbar flat color="transparent" class="round">
                    <v-toolbar-title>Licencia</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical></v-divider>
                    <v-spacer></v-spacer>

                      <v-btn
                        rounded
                        color="#064b6df0"
                        dark
                        class="mb-2"
                        @click="licenseItem">
                          <v-icon class="mr-3">mdi-account-plus</v-icon>
                          Agregar Licencia
                      </v-btn>

                    <dialogLicense
                      v-if="active_l"
                      :active="active_l"
                      :editedItem="data_license"
                      :edit="edit_l"
                      :employee_id="employee_id"
                      @dialog:change="eventdialoglicense">

                    </dialogLicense>

                </v-toolbar>
              </template>
              <template v-slot:item.status_employee_id="{ item }">
                <v-chip :color="getColor(item.status_employee_id)" dark outlined>{{ item.status_employee_id | status_employee}}</v-chip>
              </template>
              <template v-slot:item.action="{ item }">
                
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                       v-on="on"
                      @click="licenseEditItem(item)"
                    >
                        mdi-file
                    </v-icon>
                  </template>
                  <span>Editar</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                       v-on="on"
                      @click="deleteItem(item)"
                    >
                        mdi-account-remove
                    </v-icon>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>

                <!-- <v-icon
                    small
                    class="mr-2"
                    @click="licenseEditItem(item)"
                >
                    mdi-file
                </v-icon> -->
                <!-- <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-account-edit
                </v-icon> -->
                <!-- <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-account-remove
                </v-icon> -->
              </template>
            </v-data-table>
          </v-card>
        </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import Swal from 'sweetalert2';
  import dialogCompany from './Dialog';
  import dialogLicense from './DialogLicense';

  export default {
    components: {
      dialogCompany,
      dialogLicense
    },

    data: () => ({
    employee_id: '',
    active_l: false,
    data_license: {},
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
        { text: 'Numero', align: 'left', sortable: false, value: 'number', class: 'length_text'},
        { text: 'Observacion', value: 'observation', class: 'length_text' },
        { text: 'Fecha de expiracion', value: 'expiration', class: 'length_text' },
        { text: 'Acciones', value: 'action', sortable: false, class: 'length_text' },
      ],
      desserts: [],
    }),

    filters: {
      status_employee(value) {
        if (value==1) {
          return 'Activo'
        }else {
          return 'Inactivo'
        }
      }
    },


    computed: {
      formTitle () {
        return this.edit === false ? 'Nueva Licencia' : 'Editar Licencia'
      },
      ItemsLicense() {
        return this.$store.getters["employee/GET_LICENSE"];
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize();
      this.license_type();
      this.license_letter();
    },

    methods: {
      async initialize () {
        try {
          const request = {
            id: this.$route.params.id
          }
          const response = await this.$store.dispatch("employee/INDEX_LICENSE",request);
        } catch (error) {
          console.log(error);
        }
      },

      eventdialog(message) {
        if (message === 'registro') {
          Swal.fire({
              icon: 'success',
              title: 'Empleado creado con exito',
            })
          this.active = false;
          this.edit = false;
        }else if (message === 'editar') {
          Swal.fire({
              icon: 'success',
              title: 'Empleado editado con exito',
            })
          this.active = false;
          this.edit = false;
        }else {
          this.active = false;
          this.edit = false;
        }
      },

      eventdialoglicense(message) {
        if (message === 'registro') {
          Swal.fire({
              icon: 'success',
              title: 'Licencia creado con exito',
            })
          this.active_l = false;
          this.edit_l = false;
        }else if (message === 'editar') {
          Swal.fire({
              icon: 'success',
              title: 'Licencia editado con exito',
            })
          this.active_l = false;
          this.edit_l = false;
        }else {
          this.active_l = false;
          this.edit_l = false;
        }
      },

      registerItem (item) {
        this.data_edit = {

        }
        this.active = true
        this.edit = false
      },

      editItem (item) {
        this.data_edit = {
          ...item,
          position_array: this.ItemsLicense.indexOf(item)
        }

        this.active = true
        this.edit = true
      },

      licenseItem () {
        this.data_license = {
        }
        this.active_l = true
        this.edit_l = false
        this.employee_id = this.$route.params.id

      },

      licenseEditItem (item) {
        let array = item.type_license.map(function(index, elem) {
                                          return index.id;
                                        })
        // con
        this.data_license = {
          ...item,
          type_license_id : array,
          employee_id: this.$route.params.id,
          position_array: this.ItemsLicense.indexOf(item)
        }

        this.active_l = true
        this.edit_l = true
      },

      async deleteItem (item) {
        try {
            Swal.fire({
                title: 'Esta seguro que desea borrar la licencia ?',
                text: "No podra revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E53935',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then(async (result) => {
                if (result.value) {
                    const request = {
                        position_array: this.ItemsLicense.indexOf(item),
                        ...item
                    }
                    const response = await this.$store.dispatch("employee/DELETE_LICENSE", request);
                      Swal.fire({
                        title: 'Eliminado!',
                        text: "Su licencia fue elimando con exito",
                        icon: 'success',
                        confirmButtonColor: '#E53935',
                      })
                }
            })
            
        } catch (error) {
            console.log(error);
        }
        // confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },

      close () {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
          this.edit = false;
        }, 300)
      },

      getColor (value) {
        if (value == 1) {
          return 'success'
        } else {
          return 'red'
        }
      },
     async license_type() {
        try {
            const response = await this.$store.dispatch("employee/LICENSE_TYPE");
          } catch (error) {
            console.log(error);
          }
      },
      async license_letter() {
        try {
            const response = await this.$store.dispatch("employee/LICENSE_LETTER");
          } catch (error) {
            console.log(error);
          }
      },

    },
  }
</script>

<style>
.length_text {
  font-size: 1rem !important
}
</style>
