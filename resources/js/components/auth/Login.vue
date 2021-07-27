<template>
  <v-app id="inspire">
    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="8"
            md="4"
            style="margin-top: -5%"
          >
            <v-img src="img/vaca.jpg" width="50%" style="margin-left: 22%" class="mb-6"></v-img>
            <v-card class="shadow-large round">
              <v-toolbar
                color="red darken-1"
                dark
                flat
              >
                <v-toolbar-title>RECURSOS HUMANOS</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    label="Email"
                    name="email"
                    prepend-icon="mdi-account"
                    type="email"
                    v-model="email"
                  />

                  <v-text-field
                    id="password"
                    label="Password"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    v-model="password"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn
                  block
                  dark
                  rounded
                  color="#064b6df0"
                  @click="login"
                  :loading="loading"
                >Iniciar Sesión</v-btn>
                <v-spacer />

              </v-card-actions>
            </v-card>
          </v-col>
          <v-snackbar
            v-model="snackbar"
            top
          >
            {{ text }}
            <v-btn
              dark
              text
              color='pink'
              @click="snackbar = false"
              class="font-weight-bold"
            >
              Cerrar
            </v-btn>
          </v-snackbar>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      snackbar: false,
      text: '',
      email: '',
      password: '',
      loading: false
    }),
    methods: {
    async login() {
      try {
        this.loading = true;
        const request = {
          email: this.email,
          password: this.password
        };
        const response = await this.$store.dispatch("auth/LOGIN_USER", request);
        // console.log(response)
        // this.loading = false;
        await this.$router.push({name: "dashboard"});
      } catch (error) {

        this.loading = false;
        this.text = 'Datos invalidos'
        this.snackbar = true
        console.log(error);
      }
    }
  }
  }
</script>
