<template>
  <v-container>
    <v-row>
        <v-col>
          <v-snackbar
            v-model="snackbar"
          >
            Se estan cargando los datos por favor espere
            

            <!-- <template v-slot:action="{ attrs }">
              <v-btn
                color="red"
                text
                v-bind="attrs"
                @click="snackbar = false"
              >
                Cerrar
              </v-btn>
            </template> -->
          </v-snackbar>
          <v-card class="shadow-large round">
            <v-data-table
              :headers="headers"
              :items="ItemsEmployee"
              :page.sync="page"
              :items-per-page="itemsPerPage"
              :server-items-length="pagination.total"
              :options.sync="options"
              sort-by="calories"
              class="elevation-0"
              hide-default-footer
              @page-count="pageCount = $event">
              <template v-slot:top>
                <v-toolbar flat color="transparent" class="round">
                    <v-toolbar-title>Empleados</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical></v-divider>
                    <v-spacer></v-spacer>

                      <v-btn
                        rounded
                        color="#064b6df0"
                        dark
                        class="mb-2 shadow-small"
                        @click="registerItem">
                          <v-icon class="mr-3">mdi-account-plus</v-icon>
                          Agregar Empleado
                      </v-btn>

                    <dialogCompany
                      v-if="active"
                      :active="active"
                      :editedItem="data_edit"
                      :edit="edit"
                      @dialog:change="eventdialog">

                    </dialogCompany>

                    <dialogLicense
                      v-if="active_l"
                      :active="active_l"
                      :editedItem="data_license"
                      :edit="edit_l"
                      :employee_id="employee_id"
                      @dialog:change="eventdialoglicense">

                    </dialogLicense>

                </v-toolbar>

                <v-col cols="12" sm="6" md="4">
                  <v-spacer></v-spacer>
                  <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    single-line
                    hide-details
                    @keyup.enter="getFilter"
                  ></v-text-field>
                </v-col>

              </template>
              <template v-slot:item.occupation_data.status_employee.name="{ item }">
                <v-chip :color="getColor(item.occupation_data.status_employee_id)" dark outlined>
                  {{ item.occupation_data.status_employee.name }}
                </v-chip>
              </template>
              <template v-slot:item.action="{ item }">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                      v-on="on"
                      @click="license(item)">
                      mdi-file
                    </v-icon>
                  </template>
                  <span>Licencia</span>
                </v-tooltip>

                <!-- <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                        small
                        class="mr-2"
                        v-on="on"
                        @click="dependent(item)">
                        mdi-account-alert
                    </v-icon>
                  </template>
                  <span>Dependientes</span>
                </v-tooltip> -->

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                      v-on="on"
                      @click="credentials(item)">
                      mdi-card
                    </v-icon>
                  </template>
                  <span>Carnet</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                      v-on="on"
                      @click="salary(item)">
                      mdi-cash-multiple
                    </v-icon>
                  </template>
                  <span>Salario</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                      v-on="on"
                      @click="module_creator(item)">
                      mdi-cash-multiple
                    </v-icon>
                  </template>
                  <span>Modulo acreedor</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                      v-on="on"
                      @click="dni(item)">
                      mdi-file
                    </v-icon>
                  </template>
                  <span>Cedula</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      class="mr-2"
                      v-on="on"
                      @click="editItem(item)"
                    >
                        mdi-account-edit
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
                      @click="showItem(item)"
                    >
                        mdi-eye
                    </v-icon>
                  </template>
                  <span>Ver</span>
                </v-tooltip>

                <!-- <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-icon
                      small
                      v-on="on"
                      @click="deleteItem(item)"
                    >
                        mdi-account-remove
                    </v-icon>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip> -->



              </template>
            </v-data-table>
            <div class="text-center pt-2">
              <v-pagination
                circle
                v-model="page"
                :length="pagination.page_count"
                :total-visible="7">
              </v-pagination>
            </div>
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
    snackbar: false,
    initialize_status: false,
    department_types_status: false,
    payment_methods_status: false,
    position_status: false,
    contract_type_status: false,
    status_employee_status: false,
    license_type_status: false,
    status_marital_status: false,
    bank_status: false,
    contract_termination_status: false,
    options: {},
    page: 1,
    pageCount: 2,
    itemsPerPage: 25,
    total: 2,
    search: '',
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
    dialog: false,
    headers: [
      { text: 'Apellido', value: 'last_name',sortable: false, class: 'length_text' },
      { text: 'Nombre', align: 'left', sortable: false, value: 'name', class: 'length_text'},
      { text: 'Estatus', value: 'occupation_data.status_employee.name',sortable: false, class: 'length_text' },
      { text: 'Acciones', value: 'action', sortable: false, class: 'length_text' },
    ],
    desserts: [],
    }),

    filters: {

    },

    computed: {
      formTitle () {
        return this.edit === false ? 'Nuevo Empleado' : 'Editar Empleado'
      },
      ItemsEmployee() {
        return this.$store.getters["employee/GET_EMPLOYEE"];
      },
      pagination() {
        return this.$store.getters["employee/PAGINATION"];
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      options: {
        async handler() {
          try {
            this.loading = true;
            const payload = {
              page: this.page,
              itemsPerPage: this.itemsPerPage
            };
            await this.$store.dispatch("employee/GET_PAGINATE_EMPLOYEE", payload);
          } catch (error) {
            console.error(error);
            this.$snotify.error("Error al cargar listado de usuarios.", "¡Vaya!");
          } finally {
            this.loading = false;
          }
        },
        deep: true
      }
    },

    created () {
      this.initialize();
      this.department_types();
      this.payment_methods();
      this.position();
      this.contract_type();
      this.status_employee();
      this.license_type();
      this.status_marital();
      this.bank();
      this.contract_termination();
    },

    methods: {
      async initialize () {
        try {
          const response = await this.$store.dispatch("employee/INDEX_EMPLOYEE");
          this.initialize_status = true
        } catch (error) {
          this.initialize_status = false
          console.log(error);
        }
      },
      async getFilter () {
        try {
          const request = {
            name: this.search
          }
          const response = await this.$store.dispatch("employee/SEARCH_EMPLOYEE", request);
        } catch (error) {
          console.log(error);
        }
      },

      license(item) {
        this.$router.push({
          name: "license",
          params: { id: item.id }
        });
      },

      credentials(item) {
        this.$router.push({
          name: "driving_license",
          params: { id: item.id }
        });
      },

      dependent(item) {
          this.$router.push({
              name: "dependent",
              params: { id: item.id }
          });
      },
      salary(item) {
          this.$router.push({
              name: "salary",
              params: { id: item.id }
          });
      },
      module_creator(item) {
        this.$router.push({
              name: "module_creditor",
              params: { id: item.id }
          });
      },
      dni(item) {
        this.$router.push({
              name: "dni",
              params: { id: item.id }
          });
      },

      showItem(item) {
        this.$router.push({
              name: "employee_detail",
              params: { id: item.id }
          });
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
        if(
            this.department_types_status ==
            this.payment_methods_status ==
            this.position_status ==
            this.contract_type_status ==
            this.status_employee_status ==
            this.license_type_status ==
            this.status_marital_status ==
            this.bank_status ==
            this.contract_termination_status == true
        ){
          this.data_edit = {
            name: '',
            middle_name: '',
            last_name: '',
            second_surname: '',
            dni: '',
            photo_dni: [],
            photo: [],
            status_marital_id: '',
            contact: {
              tlf_home: '',
              tlf_movil: '',
              tlf_other: '',
              email: '',
            },
            address: {
              name: '',
              car: {
                status_car: '',
                brand: '',
                model: '',
                license_plate: '',
                driver_license: '',
              }
            },
            dependent: {
              name_father: '',
              name_mother: '',
              name_spouse: '',
              date_spouse: '',
              spouse_job: '',
              spouse_position: '',
              family_business: '',
              urgency_notify: '',
              urgency_relationship: '',
              urgency_res: '',
              urgency_office: '',
              urgency_address: '',
              children_status: '',
              children: [
                // {
                //   name: '',
                //   dependent: '',
                //   date: '',
                //   age: '',
                //   gender: '',
                // relationship: '',
                // }
              ]
            },
            medical_information: {
              height: '',
              weight: '',
              blood_type: '',
              donor: '',
              hospitalized: '',
              hospitalized_explain: '',
              disease: [],
              disease_explain: '',
              treatment: '',
              treatment_explain: '',
              allergic: '',
              allergic_explain: '',
              lenses: '',
              hearing: '',
              drugs: '',
              drugs_explain: '',
              psychiatric: '',
              psychiatric_explain: '',
            },
            occupation_data: {
              position_id: '',
              contract_type_id: '',
              status_employee_id: '',
              start_contract: '',
              probationary_period: '',
              end_contract: '',
              payment_method_id: '',
              department_type_id: '',
              shirt: '',
              trousers: '',
              dress: '',
              footwear: '',
              account_number: '',
              bank_id: '',
            }
          }
          this.active = true
          this.edit = false
          console.log('somos iguales')
        }else {
          this.snackbar = true
          this.validationUrls();
          // this.snackbar = false
          console.log('no somos iguales')
        }
        
      },

      editItem (item) {
        console.log('item.medical_information',item.medical_information.disease)
        // let disease = []
        // disease.push(item.medical_information.disease)
        // item.medical_information.disease == null ? [] : Array.from(item.medical_information.disease)
        // item.medical_information.disease = [...JSON.parse(item.medical_information.disease)]
        // [
        //   "Hipertensión",
        //   "Diabetes",
        //   "Asma",
        //   "Epilepsia",
        //   "Cancer",
        //   "Otra",
        //   "Ninguna",
        // ]

        if(
            this.department_types_status ==
            this.payment_methods_status ==
            this.position_status ==
            this.contract_type_status ==
            this.status_employee_status ==
            this.license_type_status ==
            this.status_marital_status ==
            this.bank_status ==
            this.contract_termination_status == true
        ){
          this.data_edit = {
            ...item,
            position_array: this.ItemsEmployee.indexOf(item),
            page: this.page
          }
  
          this.active = true
          this.edit = true
          console.log('somos iguales')
        }else {
          this.snackbar = true
          this.validationUrls();
          // this.snackbar = false
          console.log('no somos iguales')
        }


      },

      validationUrls() {
        if (this.department_types_status == false){
          this.department_types();
        }
        if (this.payment_methods_status == false){
          this.payment_methods();
        }
        if (this.position_status == false){
          this.position();
        }
        if (this.contract_type_status == false){
          this.contract_type();
        }
        if (this.status_employee_status == false){
          this.status_employee();
        }
        if (this.license_type_status == false){
          this.license_type();
        }
        if (this.status_marital_status == false){
          this.status_marital();
        }
        if (this.bank_status == false){
          this.bank();
        }
        if (this.contract_termination_status == false){
          this.contract_termination();
        }
      },

      licenseItem (item) {
        this.data_license = {
          position_array: this.ItemsEmployee.indexOf(item)
        }
        this.active_l = true
        this.edit_l = false
        this.employee_id = item.id

      },

      licenseEditItem (item) {
        this.data_license = {
          ...item.license,
          employee_id: item.id,
          position_array: this.ItemsEmployee.indexOf(item)
        }

        this.active_l = true
        this.edit_l = true
      },

      async deleteItem (item) {
        try {
          const request = {
            position_array: this.ItemsEmployee.indexOf(item),
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

      getColor (value) {
        if (value == 1) {
          return 'success'
        } else {
          return 'red'
        }
      },

      async department_types() {
          try {
            const response = await this.$store.dispatch("employee/DEPARTAMENT_TYPES");
            this.department_types_status = true
          } catch (error) {
            this.department_types_status = false
            console.log(error);
          }
      },

      async payment_methods() {
          try {
            const response = await this.$store.dispatch("employee/PAYMENT_METHODS");
            this.payment_methods_status = true
          } catch (error) {
            this.payment_methods_status = false
            console.log(error);
          }
      },
      async position() {
        try {
            const response = await this.$store.dispatch("employee/POSITION");
            this.position_status = true
          } catch (error) {
            this.position_status = false
            console.log(error);
          }
      },
      async contract_type() {
        try {
            const response = await this.$store.dispatch("employee/CONTRACT_TYPE");
            this.contract_type_status = true
          } catch (error) {
            this.contract_type_status = false
            console.log(error);
          }
      },
      async status_employee() {
        try {
            const response = await this.$store.dispatch("employee/STATUS_EMPLOYEE");
            this.status_employee_status = true
          } catch (error) {
            this.status_employee_status = false
            console.log(error);
          }
      },
      async license_type() {
        try {
            const response = await this.$store.dispatch("employee/LICENSE_TYPE");
            this.license_type_status = true
          } catch (error) {
            this.license_type_status = false
            console.log(error);
          }
      },
      async status_marital() {
        try {
            const response = await this.$store.dispatch("employee/STATUS_MARITAL");
            this.status_marital_status = true
          } catch (error) {
            this.status_marital_status = false
            console.log(error);
          }
      },
      async bank () {
        try {
          const response = await this.$store.dispatch("bank/INDEX_BANK");
            this.bank_status = true
        } catch (error) {
          this.bank_status = false
          console.log(error);
        }
      },
      async contract_termination () {
        try {
          const response = await this.$store.dispatch("employee/INDEX_CONTRACT_TERMINATION");
            this.contract_termination_status = true
        } catch (error) {
            this.contract_termination_status = false
          console.log(error);
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
