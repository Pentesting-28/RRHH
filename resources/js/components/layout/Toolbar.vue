<template>
  <v-container fluid grid-list-md>
    <v-app-bar
      color="primary"
      class="border"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer" />
      <v-toolbar-title>RRHH</v-toolbar-title>
      <v-spacer></v-spacer>
            
      <v-menu offset-y @click="">
        <template v-slot:activator="{ on }">
          <v-avatar size="32px" item v-on="on">
            <v-img src="https://cdn.vuetifyjs.com/images/logos/logo.svg" alt="Vuetify" />
          </v-avatar>
        </template>
        <v-list>
          <v-list-item @click="dialog = true">
            <v-list-item-title>Cambiar Contraseña</v-list-item-title>
          </v-list-item>
          <v-list-item @click="logout">
            <v-list-item-title>Salir <v-icon>mdi-location-exit</v-icon></v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
        
    </v-app-bar>

    <v-dialog v-model="dialog" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Cambiar Contraseña</v-card-title>
        <v-card-text>
          <v-text-field
            label="Contraseña anterior"
            outlined
            v-model="old_password"
            type="password"
            dense
          ></v-text-field>
          <v-text-field
            label="Nueva Contraseña"
            outlined
            v-model="password"
            type="password"
            dense
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="dialog = false">Cancelar</v-btn>
          <v-btn color="green darken-1" text @click="password_reset">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
  import Swal from 'sweetalert2';
export default {
  data: () => ({   
    dialog: false,
    old_password: '',
    password: ''   
  }),

  computed: {
    HandIcon() {
      const value = this.$store.getters["layout/DRAWER_VALUE"];
      return value ? "mdi-toggle-switch-off" : "mdi-toggle-switch";
    }
  },
  methods: {
    drawer() {
      let value = this.$store.getters["layout/DRAWER_VALUE"];
      value = !value;
      this.$store.commit("layout/SET_DRAWER", value);
    },
    async logout() {
      try {
        const response = await this.$store.dispatch("auth/LOGOUT");
        localStorage.clear();
        this.$router.push({ name: "login" });        
      } catch(e) {
        
        console.log(e);
      }
    },
    async password_reset() {
      try {
        const request = {
          password: this.password,
          password_confirmation: this.password,
          old_password: this.old_password
        }
        console.log('pp',request)
        const response = await this.$store.dispatch("auth/RESET_PASSWORD", request);

        this.password = ''
        this.old_password = ''
        this.dialog = false

         Swal.fire({
              icon: 'success',
              title: response.message,
            })
      } catch(e) {
        console.log('++++++++', e.response.data.message)
        Swal.fire({
              icon: 'error',
              title: e.response.data.message,
            })
      }
    }
  }
};
</script>

<style scoped>
.rounded-right { 
  border-bottom-right-radius: 15px !important
}
.rounded-left { 
  border-bottom-left-radius: 15px !important
}
.border {
  border-radius: 8px;
}
</style>