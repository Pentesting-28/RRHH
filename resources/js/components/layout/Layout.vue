<template>
  <v-app id="keep">
    <Drawer />
    <v-content style='background: #EEEEEE'>
      <Toolbar />
      <v-container fluid>
        <v-row>
          <v-col cols="12">
            <router-view />
          </v-col>
        </v-row>
      </v-container>
    <!-- <Footer /> -->
    </v-content>
  </v-app>
</template>

<script>
import Drawer from "./Drawer";
import Toolbar from "./Toolbar";
import Footer from "./Footer";

export default {
  props: {
    source: String
  },
  components: {
    Drawer,
    Toolbar,
    Footer
  },
  data: () => ({}),
  computed: {},
  methods: {}
};
</script>

<style>
</style>