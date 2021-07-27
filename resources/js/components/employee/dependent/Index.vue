<template>
  <v-container>
    <v-row>
        <v-col>
          <v-card class="shadow-large round">
            <v-data-table
              :headers="headers"
              :items="ItemsDependent"
              class="elevation-0">
              <template v-slot:top>
                <v-toolbar flat color="transparent" class="round">
                    <v-toolbar-title>Dependientes</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical></v-divider>
                    <v-spacer></v-spacer>

                      <v-btn
                        color="#E63E59"
                        dark
                        outlined
                        class="mb-2"
                        @click="registerItem">
                          <v-icon class="mr-3">mdi-account-plus</v-icon>
                          Agregar Dependiente
                      </v-btn>

                    <dialogDependent
                      v-if="active_l"
                      :active="active_l"
                      :editedItem="data_dependent"
                      :edit="edit_l"
                      :employee_id="employee_id"
                      @dialog:change="eventdialog">

                    </dialogDependent>

                </v-toolbar>
              </template>
              <template v-slot:item.action="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)" >
                    mdi-account-edit
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                >
                    mdi-account-remove
                </v-icon>
              </template>
            </v-data-table>
          </v-card>
        </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import Swal from 'sweetalert2';
  import dialogDependent from './Dialog';

  export default {
    components: {
        dialogDependent
    },

    data: () => ({
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
        { text: 'Nombre', align: 'left', sortable: false, value: 'name', class: 'length_text'},
        { text: 'Parentesco', value: 'relationship', class: 'length_text' },
        { text: 'Edad', value: 'age', class: 'length_text' },
        { text: 'Acciones', value: 'action', sortable: false, class: 'length_text' },
      ],
      desserts: [],
    }),



    computed: {
      formTitle () {
        return this.edit === false ? 'Nuevo Dependiente' : 'Editar Dependiente'
      },
      ItemsDependent() {
        return this.$store.getters["employee/GET_DEPENDENT"];
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize();
    },

    methods: {
      async initialize () {
        try {
          const request = {
            id: this.$route.params.id
          }
          const response = await this.$store.dispatch("employee/INDEX_DEPENDENT",request);
        } catch (error) {
          console.log(error);
        }
      },


      eventdialog(message) {
        console.log(message,'ooooooooooooooo')
        if (message === 'registro') {
          Swal.fire({
              icon: 'success',
              title: 'Dependiente creado con exito',
            })
          this.active_l = false;
          this.edit_l = false;
        }else if (message === 'editar') {
          Swal.fire({
              icon: 'success',
              title: 'Dependiente editado con exito',
            })
          this.active_l = false;
          this.edit_l = false;
        }else {
          this.active_l = false;
          this.edit_l = false;
        }
      },

      // registerItem (item) {
      //   this.data_edit = {}
      //   this.active_l = true
      // },

      editItem (item) {
        this.data_dependent = {
          ...item,
          position_array: this.ItemsDependent.indexOf(item)
        }

        this.active_l = true
        this.edit_l = true
      },


      registerItem (item) {
        this.data_dependent = {
          ...item,
          employee_id: this.$route.params.id,
          position_array: this.ItemsDependent.indexOf(item)
        }

        this.active_l = true
      },

      async deleteItem (item) {
        try {
          const request = {
            position_array: this.ItemsDependent.indexOf(item),
            ...item
          }
          console.log(request,'*******')
          const response = await this.$store.dispatch("employee/DELETE", request);
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




    },
  }
</script>

<style>
.length_text {
  font-size: 1rem !important
}
</style>
