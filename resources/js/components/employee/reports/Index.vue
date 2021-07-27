<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card class="shadow-large round">
          <v-data-table
            :headers="headers_original"
            :items="ItemsReports"
            class="elevation-0"
          >
            <template v-slot:top>
              <v-toolbar flat color="transparent" class="round">
                <v-toolbar-title>Generador de reportes</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-container class="py-0">
                <v-row>
                  <v-col cols="12" sm="4" class="py-0">
                    <v-autocomplete
                      v-model="departament_id"
                      :items="ItemsDepartment"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el departamento"
                      outlined
                      dense
                      class="mt-6"
                      v-if="report_id > 0"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0">
                    <v-autocomplete
                      v-model="position_id"
                      :items="ItemsPosition"
                      item-text="name"
                      item-value="id"
                      label="Seleccione la posición"
                      outlined
                      dense
                      class="mt-6"
                      v-if="report_id > 0"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0">
                    <v-autocomplete
                      v-model="report_id"
                      :items="type_reports"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el tipo de reporte"
                      outlined
                      dense
                      class="mt-6"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 1">
                    <v-text-field
                      label="Indique el tipo de sangre"
                      outlined
                      dense
                      v-model="blood_type"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4" md="4" v-if="report_id == 3">
                    <v-menu
                      v-model="menu2"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="expiration"
                          label="Seleccione la fecha de vencimiento"
                          append-icon="mdi-calendar"
                          readonly
                          outlined
                          dense
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="expiration"
                        no-title
                        @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12" sm="4" md="4" v-if="report_id == 4">
                    <v-menu
                      v-model="menu2"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="expirationLicense"
                          label="Seleccione la fecha de vencimiento"
                          append-icon="mdi-calendar"
                          readonly
                          outlined
                          dense
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="expirationLicense"
                        no-title
                        @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 10">
                    <v-text-field
                      label="Salario minimo"
                      outlined
                      dense
                      type="number"
                      v-model="salaryFrom"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 10">
                    <v-text-field
                      label="Salario maximo"
                      outlined
                      dense
                      type="number"
                      v-model="salaryUpTo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 11">
                    <v-autocomplete
                      v-model="creditor_id"
                      :items="ItemsCreditor"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el acreedor"
                      outlined
                      dense
                      class="mt-6"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 12">
                    <v-autocomplete
                      v-model="status_employee_id"
                      :items="ItemsStatusEmployee"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el estatus del colaborador"
                      outlined
                      dense
                      class="mt-6"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 12">
                    <v-autocomplete
                      v-model="contract_type_id"
                      :items="ItemsContratType"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el tipo de contrato"
                      outlined
                      dense
                      class="mt-6"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" md="4" v-if="report_id == 13">
                    <v-menu
                      v-model="menu2"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="end_contract"
                          label="Seleccione la fecha de vencimiento"
                          append-icon="mdi-calendar"
                          readonly
                          outlined
                          dense
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="end_contract"
                        no-title
                        @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 13">
                    <v-autocomplete
                      v-model="contract_termination_id"
                      :items="ItemsContractTermination"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el motivo"
                      outlined
                      dense
                      class="mt-3"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 14">
                    <v-autocomplete
                      v-model="payment_method_id"
                      :items="ItemsPaymentMethods"
                      item-text="name"
                      item-value="id"
                      label="Seleccione el metodo de pago"
                      outlined
                      dense
                      class="mt-6"
                      @change="initialize"
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0" v-if="report_id == 14">
                    <v-checkbox
                      v-model="accountProtection"
                      :label="`Poner asteriscos: ${accountProtection == true ? 'Si' : 'No'}`"
                    ></v-checkbox>
                  </v-col>
                  <v-col cols="12" sm="4" class="py-0">
                    <v-btn
                      color="#064b6df0"
                      dark
                      rounded
                      @click="initialize"
                      v-if="
                        report_id == 1 ||
                        report_id == 3 ||
                        report_id == 4 ||
                        report_id == 10 ||
                        report_id == 11 ||
                        report_id == 12 ||
                        report_id == 13 ||
                        report_id == 14
                      "
                      >Buscar</v-btn
                    >
                    <v-btn dark rounded color="grey" @click="clearItems"
                      >Limpiar Filtros</v-btn
                    >
                  </v-col>
                </v-row>
                <v-row justify="end" class="px-7">
                  <v-btn
                    color="red"
                    class
                    icon
                    large
                    v-if="report_id > 0"
                    @click="pdf"
                  >
                    <!-- target="_blank"
                    :href="pdf()" -->
                    <v-icon large>mdi-file-pdf</v-icon>
                  </v-btn>
                </v-row>
              </v-container>
            </template>
            <template v-slot:item.medical_information.disease="{ item }">
              <!-- {{item.medical_information.disease}} -->
              <!-- <ul> -->
              <span
                v-for="i in JSON.parse(item.medical_information.disease)"
                :key="i"
              >
                {{ i }} |
              </span>
              <!-- </ul> -->
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Swal from "sweetalert2";
// import dialogSalary from './Dialog';.

export default {
  // components: {
  //     dialogSalary
  // },

  data: () => ({
    menu2: false,
    blood_type: "",
    expiration: "",
    expirationLicense: "",
    salaryFrom: "",
    salaryUpTo: "",
    creditor_id: "",
    status_employee_id: "",
    contract_type_id: "",
    end_contract: "",
    payment_method_id: "",
    contract_termination_id: "",
    accountProtection: false,
    report_id: 0,
    headers_original: [],
    departament_id: 0,
    position_id: 0,
    headers: [
      { text: "Nombre", value: "name", class: "length_text", name: 0 },
      { text: "Apellido", value: "last_name", class: "length_text", name: 0 },
      { text: "Cedula", value: "dni", class: "length_text", name: 0 },
      {
        text: "Tipo de sangre",
        value: "medical_information.blood_type",
        class: "length_text",
        name: 1,
      },
      {
        text: "Padecimientos",
        value: "medical_information.disease",
        class: "length_text",
        name: 2,
      },
      {
        text: "Fecha de expedicion",
        value: "driving_license.expiration",
        class: "length_text",
        name: 3,
      },
      {
        text: "Carnet de salud",
        value: "driving_license.license_types.name",
        class: "length_text",
        name: 3,
      },
      { text: "Nombre", value: "employee.name", class: "length_text", name: 4 },
      {
        text: "Apellido",
        value: "employee.last_name",
        class: "length_text",
        name: 4,
      },
      { text: "Cedula", value: "employee.dni", class: "length_text", name: 4 },
      {
        text: "Tipo de licencia",
        value: "type_license[0].name",
        class: "length_text",
        name: 4,
      },
      {
        text: "Fecha de expiración",
        value: "expiration",
        class: "length_text",
        name: 4,
      },
      {
        text: "Placa",
        value: "address.car.license_plate",
        class: "length_text",
        name: 5,
      },
      {
        text: "Marca",
        value: "address.car.brand",
        class: "length_text",
        name: 5,
      },
      {
        text: "Modelo",
        value: "address.car.model",
        class: "length_text",
        name: 5,
      },
      {
        text: "Fecha de vencimiento",
        value: "dnis.expiration",
        class: "length_text",
        name: 6,
      },
      {
        text: "Direccion registrada",
        value: "address.name",
        class: "length_text",
        name: 7,
      },
      {
        text: "Dependientes",
        value: "dependent.children_status",
        class: "length_text",
        name: 8,
      },
      {
        text: "Departamento",
        value: "occupation_data.department_type.name",
        class: "length_text",
        name: 9,
      },
      {
        text: "Posicion",
        value: "occupation_data.position.name",
        class: "length_text",
        name: 9,
      },
      {
        text: "Departamento",
        value: "occupation_data.department_type.name",
        class: "length_text",
        name: 10,
      },
      {
        text: "Posicion",
        value: "occupation_data.position.name",
        class: "length_text",
        name: 10,
      },
      {
        text: "Salario",
        value: "salary[0].salary",
        class: "length_text",
        name: 10,
      },
      {
        text: "Nombre",
        value: "employee.name",
        class: "length_text",
        name: 11,
      },
      {
        text: "Apellido",
        value: "employee.last_name",
        class: "length_text",
        name: 11,
      },
      { text: "Cedula", value: "employee.dni", class: "length_text", name: 11 },
      {
        text: "Tipo de gasto",
        value: "type_expense.name",
        class: "length_text",
        name: 11,
      },
      {
        text: "Acreedor",
        value: "creditor.name",
        class: "length_text",
        name: 11,
      },
      { text: "Cantidad", value: "quantity", class: "length_text", name: 11 },
      {
        text: "Tipo de contrato",
        value: "occupation_data.contract_type.name",
        class: "length_text",
        name: 12,
      },
      {
        text: "Estatus del empleado",
        value: "occupation_data.status_employee.name",
        class: "length_text",
        name: 12,
      },
      {
        text: "Inicio de contrato",
        value: "occupation_data.start_contract",
        class: "length_text",
        name: 12,
      },
      {
        text: "Fin de contrato",
        value: "occupation_data.end_contract",
        class: "length_text",
        name: 13,
      },
      {
        text: "Motivos de terminacion",
        value: "occupation_data.contract_termination.name",
        class: "length_text",
        name: 13,
      },
      {
        text: "Metodo de pago",
        value: "occupation_data.payment_method.name",
        class: "length_text",
        name: 14,
      },
      {
        text: "Banco",
        value: "occupation_data.bank.name",
        class: "length_text",
        name: 14,
      },
      {
        text: "Numero de cuenta",
        value: "occupation_data.account_number",
        class: "length_text",
        name: 14,
      },

      // {text: 'Accion', value: 'action', class: 'length_text'},
    ],
    type_reports: [
      { id: 1, name: "Tipo de sangre" },
      { id: 2, name: "Padecimientos" },
      { id: 3, name: "Carnet de Salud" },
      { id: 4, name: "Licencias de Conducir" },
      { id: 5, name: "Placas" },
      { id: 6, name: "Cédulas" },
      { id: 7, name: "Domicilios" },
      { id: 8, name: "Dependientes" },
      { id: 9, name: "Departamentos" },
      { id: 10, name: "Salarios" },
      { id: 11, name: "Reporte de acreedores" },
      { id: 12, name: "Estatus del colaborador" },
      { id: 13, name: "Motivos Terminación laboral" },
      { id: 14, name: "Tipo de cobro" },
    ],
  }),

  computed: {
    formTitle() {
      return this.edit === false ? "Nuevo Salario" : "Editar Salario";
    },
    ItemsReports() {
      return this.$store.getters["reports/GET_REPORTS"];
    },
    ItemsDepartment() {
      return this.$store.getters["department/GET_DEPARTMENT"];
    },
    ItemsPosition() {
      return this.$store.getters["position/GET_POSITION"];
    },
    ItemsCreditor() {
      return this.$store.getters["creditor/GET_CREDITOR"];
    },
    ItemsStatusEmployee() {
      return this.$store.getters["employee/GET_STATUS_EMPLOYEE"];
    },
    ItemsPaymentMethods() {
      return this.$store.getters["employee/GET_PAYMENT_METHODS"];
    },
    ItemsContratType() {
      return this.$store.getters["employee/GET_CONTRACT_TYPE"];
    },
    ItemsContractTermination() {
      return this.$store.getters["employee/GET_CONTRACT_TERMINATION"];
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.departaments();
    this.positions();
    this.creditor();
    this.status_employee();
    this.payment_methods();
    this.contract_type();
    this.contract_termination();
    // this.initialize();
    // this.salary_type();
  },

  methods: {
    pdf() {
      console.log(process.env.MIX_APP_URL);
      let form = document.createElement("form");
      form.setAttribute("method", "post");
      form.setAttribute(
        "action",
        `${process.env.MIX_APP_URL}/api/filtered_out_pdf/${this.report_id}/${this.departament_id}/${this.position_id}`
      );

      form.setAttribute("target", "view");

      var hiddenField = document.createElement("input");
      hiddenField.setAttribute("type", "hidden");
      if (this.report_id == 1 && this.blood_type !== "") {
        hiddenField.setAttribute("name", "blood_type");
        hiddenField.setAttribute("value", this.blood_type);
      }
      if (this.report_id == 3 && this.expiration !== "") {
        hiddenField.setAttribute("name", "expiration");
        hiddenField.setAttribute("value", this.expiration);
      }
      if (this.report_id == 4 && this.expiration !== "") {
        hiddenField.setAttribute("name", "expirationLicense");
        hiddenField.setAttribute("value", this.expirationLicense);
      }
      if (this.report_id == 10 && this.salaryFrom !== "") {
        hiddenField.setAttribute("name", "salaryFrom");
        hiddenField.setAttribute("value", this.salaryFrom);
      }
      if (this.report_id == 10 && this.salaryUpTo != "") {
        hiddenField.setAttribute("name", "salaryUpTo");
        hiddenField.setAttribute("value", this.salaryUpTo);
      }
      if (this.report_id == 11 && this.creditor_id != "") {
        hiddenField.setAttribute("name", "creditor_id");
        hiddenField.setAttribute("value", this.creditor_id);
      }
      if (this.report_id == 12 && this.status_employee_id != "") {
        hiddenField.setAttribute("name", "status_employee_id");
        hiddenField.setAttribute("value", this.status_employee_id);
      }
      if (this.report_id == 12 && this.contract_type_id != "") {
        hiddenField.setAttribute("name", "contract_type_id");
        hiddenField.setAttribute("value", this.contract_type_id);
      }
      if (this.report_id == 13 && this.end_contract !== '') {
        hiddenField.setAttribute("name", "end_contract");
        hiddenField.setAttribute("value", this.end_contract);
      }
      if (this.report_id == 13 && this.contract_termination_id !== '') {
        hiddenField.setAttribute("name", "contract_termination_id");
        hiddenField.setAttribute("value", this.contract_termination_id);
      }
      if (this.report_id == 14 && this.payment_method_id !== '') {
        hiddenField.setAttribute("name", "payment_method_id");
        hiddenField.setAttribute("value", this.payment_method_id);       
      }
      if (this.report_id == 14) {
        const asteriscos = (this.accountProtection == true) ? 1 : 0;

        console.log('asteriscos', asteriscos)
        hiddenField.setAttribute("name", "accountProtection");
        hiddenField.setAttribute("value", asteriscos);        
      }

      form.appendChild(hiddenField);
      document.body.appendChild(form);

      window.open("", "view");

      form.submit();

      return `${process.env.MIX_APP_URL}/api/filtered_out_pdf/${this.report_id}/${this.departament_id}/${this.position_id}`;
    },
    async initialize() {
      try {
        const request = {
          id: this.report_id,
          departament_id: this.departament_id,
          position_id: this.position_id,
        };

        // tipo de sangre
        this.report_id == 1 && this.blood_type !== ""
          ? (request.blood_type = this.blood_type)
          : "";
        // carne de salud
        this.report_id == 3 && this.expiration !== ""
          ? (request.expiration = this.expiration)
          : "";
        // Licencias de Conducir
        this.report_id == 4 && this.expirationLicense !== ""
          ? (request.expirationLicense = this.expirationLicense)
          : "";
        // salario
        this.report_id == 10 && this.salaryFrom !== ""
          ? (request.salaryFrom = this.salaryFrom)
          : "";
        this.report_id == 10 && this.salaryUpTo !== ""
          ? (request.salaryUpTo = this.salaryUpTo)
          : "";
        // reporte de acreedores
        this.report_id == 11 && this.creditor_id != ""
          ? (request.creditor_id = this.creditor_id)
          : "";
        // estaus del empleado
        this.report_id == 12 && this.status_employee_id != ""
          ? (request.status_employee_id = this.status_employee_id)
          : "";
        this.report_id == 12 && this.contract_type_id != ""
          ? (request.contract_type_id = this.contract_type_id)
          : "";
        // Motivos Terminación laboral
        (this.report_id == 13 && this.end_contract !== '') ? (request.end_contract = this.end_contract) : "";
        (this.report_id == 13 && this.contract_termination_id !== '') ? (request.contract_termination_id = this.contract_termination_id) : "";
        

        if (this.report_id == 14 && this.payment_method_id !== '') {
          request.payment_method_id = this.payment_method_id
          request.accountProtection = this.accountProtection
        };

        this.headers_original = this.headers.filter((index) => {
          if (this.report_id == 4 || this.report_id == 11) {
            return index.name == this.report_id;
          } else {
            return index.name == 0 || index.name == this.report_id;
          }
        });



        console.log("request", request);
        const response = await this.$store.dispatch("reports/INDEX", request);
      } catch (error) {
        console.log(error);
      }
    },
    async departaments() {
      try {
        const response = await this.$store.dispatch(
          "department/INDEX_DEPARTMENT"
        );
      } catch (error) {
        console.log(error);
      }
    },
    async positions() {
      try {
        const response = await this.$store.dispatch("position/INDEX_POSITION");
      } catch (error) {
        console.log(error);
      }
    },
    async creditor() {
      try {
        const response = await this.$store.dispatch("creditor/INDEX");
      } catch (error) {
        console.log(error);
      }
    },
    async status_employee() {
      try {
        const response = await this.$store.dispatch("employee/STATUS_EMPLOYEE");
        this.status_employee_status = true;
      } catch (error) {
        this.status_employee_status = false;
        console.log(error);
      }
    },
    async payment_methods() {
      try {
        const response = await this.$store.dispatch("employee/PAYMENT_METHODS");
        this.payment_methods_status = true;
      } catch (error) {
        this.payment_methods_status = false;
        console.log(error);
      }
    },
    async contract_type() {
      try {
        const response = await this.$store.dispatch("employee/CONTRACT_TYPE");
        this.contract_type_status = true;
      } catch (error) {
        this.contract_type_status = false;
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
    },
    async clearItems() {
      this.blood_type = "";
      this.expiration = "";
      this.expirationLicense = "";
      this.salaryFrom = "";
      this.salaryUpTo = "";
      this.creditor_id = "";
      this.status_employee_id = "";
      this.end_contract = "";
      this.payment_method_id = "";
      this.report_id = 0;
      this.departament_id = 0;
      this.position_id = 0;
    },
  },
};
</script>

<style>
.length_text {
  font-size: 1rem !important;
}
</style>
