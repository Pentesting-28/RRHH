import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
// idioma
// import en from 'vuetify/en5/locale/en';

import es from 'vuetify/es5/locale/es';

Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: 'mdi'
  },
  lang: {
    locales: { es },
    current: 'es',
  },
  theme: {
    themes: {
      light: {
        primary: '#E53935',
        secondary: '#78909C',
        accent: '#6d60da',
        error: '#ff4444',
        info: '#33b5e5',
        success: '#00C851',
        warning: '#ffbb33',
      },
      dark: {
        primary: '#E53935',
        secondary: '#78909C',
        accent: '#6d60da',
        error: '#ff4444',
        info: '#33b5e5',
        success: '#00C851',
        warning: '#ffbb33',
      }
    },
  },
});