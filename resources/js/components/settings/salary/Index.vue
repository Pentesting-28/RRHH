<template>
  <v-container>
    <v-row>
        <v-col>
          <v-card class="shadow-large round">
            <v-data-table
              :headers="headers"
              :items="ItemsSalary"
              sort-by="calories"
              class="elevation-0">
              <template v-slot:top>
                <v-toolbar flat color="transparent" class="round">
                    <v-toolbar-title>Tipo de salarios</v-toolbar-title>
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
                        @click="registerItem">
                          <v-icon class="mr-3">mdi-account-plus</v-icon>
                          Nuevo Tipo de Salario
                      </v-btn>

                    <dialogPosition
                      v-if="active"
                      :active="active"
                      :editedItem="data_edit"
                      :edit="edit"
                      @dialog:change="eventdialog">

                    </dialogPosition>

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
              </template>

              <!-- <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reset</v-btn>
              </template> -->
            </v-data-table>
          </v-card>
        </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import Swal from 'sweetalert2';
  import dialogPosition from './Dialog';

  export default {
    components: {
      dialogPosition
    },

    data: () => ({
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
        { text: 'Name', align: 'left', sortable: false, value: 'name', class: 'length_text'},
        { text: 'Acciones', value: 'action', sortable: false, class: 'length_text' },
      ],
      desserts: [],
    }),



    computed: {
      formTitle () {
        return this.edit === false ? 'Nuevo Tipo de Salario' : 'Editar Tipo de Salario'
      },
      ItemsSalary() {
        return this.$store.getters["salary_type/GET_SALARY_TYPE"];
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
          const response = await this.$store.dispatch("salary_type/INDEX_SALARY_TYPE");
        } catch (error) {
          console.log(error);
        }
      },

      eventdialog(message) {
        if (message === 'registro') {
          Swal.fire({
              icon: 'success',
              title: 'Tipo de salario creado con exito',
            })
          this.active = false;
          this.edit = false;
        }else if (message === 'editar') {
          Swal.fire({
              icon: 'success',
              title: 'Tipo de salario editado con exito',
            })
          this.active = false;
          this.edit = false;
        }else {
          this.active = false;
          this.edit = false;
        }
      },

      registerItem (item) {
        this.data_edit = {}
        this.active = true
        this.edit = false
      },

      editItem (item) {
        this.data_edit = {
          ...item,
          position_array: this.ItemsSalary.indexOf(item)
        }

        this.active = true
        this.edit = true
      },

      async deleteItem (item) {
        try {
          const request = {
            position_array: this.ItemsSalary.indexOf(item),
            ...item
          }
          console.log(request,'*******')
          const response = await this.$store.dispatch("salary_type/DELETE", request);
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

    },
  }
</script>

<style>
.length_text {
  font-size: 1rem !important
}
</style>
