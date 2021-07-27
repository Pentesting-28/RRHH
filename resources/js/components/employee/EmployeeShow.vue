<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-container>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-account</v-icon>Datos
              Personales</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="3">
              <div>Primer Nombre</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Segundo Nombre</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.middle_name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Primer Apellido</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.last_name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Segundo Apellido</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.second_surname | text_complete
              }}</span>
            </v-col>
          </v-row>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="3">
              <div>Fecha de Nacimiento</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.date_birth | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Edad</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.age | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Estado Civil</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.status_marital.name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Seguro Social</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.social_security | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>DNI</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dni | text_complete
              }}</span>
            </v-col>
          </v-row>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-phone</v-icon>Contacto</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="4">
              <div>Telefono Local</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.contact.tlf_home | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Telefono Movil</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.contact.tlf_movil | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Email</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.contact.email | text_complete
              }}</span>
            </v-col>
          </v-row>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-home</v-icon>Dirección</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="4">
              <div>Dirección</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.address.name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Posee Carro</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.address.car.status_car | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Licencia de Conducir</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.address.car.driver_license | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Marca</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.address.car.brand | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Modelo</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.address.car.model | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Placa</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.address.car.license_plate | text_complete
              }}</span>
            </v-col>
          </v-row>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-home</v-icon>Familiares</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="2">
              <div>Nombre del Padre</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.name_father | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="2">
              <div>Nombre de la Madre</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.name_mother | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="8">
              <div>
                Tiene algun familiar que labore en la empresa ? en caso
                afirmativo, mencione nombre y parentesco
              </div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.family_business | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>En caso de urgencia notificar a</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.urgency_notify | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Parentesco</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.urgency_relationship | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Telefono de residencia</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.urgency_res | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Dirección</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.urgency_address | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Tiene Dependientes</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.dependent.children_status | text_complete
              }}</span>
            </v-col>
            <v-col cols="12">
              <v-data-table
                :headers="headers"
                :items="itemsEmployee.dependent.children"
                :items-per-page="5"
                class="elevation-0"
              >
              </v-data-table>
            </v-col>
          </v-row>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-home</v-icon>Medicos</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="3">
              <div>Estatura (metros)</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.height | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Peso (Libras)</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.weight | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Tipo de sangre</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.blood_type | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Donante</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.donor | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Hospitalizado</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.hospitalized | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Explique</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.hospitalized_explain
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>A sufrido alguna de las siguientes enfermedades</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.disease | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Explique</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.disease_explain
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>
                Esta bajo tratamiento médicoo sufre algun impedimento fisico
              </div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.treatment | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Explique</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.treatment_explain
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Es alergico</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.allergic | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Indique a cuales sustancias</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.allergic_explain
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Usa lentes</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.lenses | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Tiene buena audición</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.hearing | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Ha estado en tratamiento por drogas ?</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.drugs | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Explique</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.drugs_explain | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>
                Tiene algun familiar con problemas psiquiatricos o nerviosos
              </div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.psychiatric | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Quién</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.medical_information.psychiatric_explain
                  | text_complete
              }}</span>
            </v-col>
          </v-row>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-home</v-icon>Cargo</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="2">
              <div>Posicion</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.position.name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="2">
              <div>Tipo de contrato</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.contract_type.name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="2">
              <div>Estatus del empleado</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.status_employee.name
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="2">
              <div>Inicio de contrato</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.start_contract | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="2">
              <div>Tiempo probatorio</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.probationary_period
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="2">
              <div>Metodo de pago</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.payment_method.name
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Banco</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.bank.name | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Número de cuenta</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.account_number | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <div>Departamento</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.department_type.name
                  | text_complete
              }}</span>
            </v-col>
            <v-col cols="12">
              <v-icon>mdi-tag</v-icon>Tallas de uniforme
              <v-divider></v-divider>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Camisa</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.shirt | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Pantalón</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.trousers | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Vestido</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.dress | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="3">
              <div>Calzado</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.footwear | text_complete
              }}</span>
            </v-col>
          </v-row>
          <v-toolbar
            dense
            flat
            color="#064b6df0"
            dark
            style="border-radius: 10px"
          >
            <v-toolbar-title
              ><v-icon class="mr-2">mdi-home</v-icon>Finalización de contrato</v-toolbar-title
            >
          </v-toolbar>
          <v-row class="px-5">
            <v-col cols="12" sm="6" md="6">
              <div>Finalizacion del contrato</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.end_contract | text_complete
              }}</span>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <div>Motivo</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.contract_termination | text_complete
              }}</span>
            </v-col>
            <v-col cols="12">
              <div>Razón</div>
              <span class="grey--text text--darken-1">{{
                itemsEmployee.occupation_data.end_your_contract | text_complete
              }}</span>
            </v-col>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    itemsEmployee: {},
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
    ],
  }),

  filters: {
    text_complete(value) {
      return value == null ? "-----" : value;
    },
  },

  computed: {},

  // watch: {
  //   dialog (val) {
  //     val || this.close()
  //   },
  // },

  created() {
    this.initialize();
  },

  methods: {
    async initialize() {
      try {
        const request = {
          id: this.$route.params.id,
        };
        const response = await this.$store.dispatch(
          "employee/SHOW_EMPLOYEE",
          request
        );
        console.log("response EMPLOYEE", response.data);
        this.itemsEmployee = response.data;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
</style>