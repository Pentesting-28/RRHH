<template>
    <v-app>
        <router-view />
    </v-app>
</template>

<script>
    export default {
        name: 'App',
        data () {
            return {}
        },
        created() {
            // this.$store.dispatch("auth/TRY_AUTO_LOGIN");
        }
    }
</script>
<style>
.round {
  border-radius: 20px !important;
}
.shadow-large {
  box-shadow: 0 1px 15px rgba(27, 31, 35, 0.15) !important;
}


</style>
