import { currency } from './currency'

// crear plugin vue

export default {

  install(Vue) {
    Vue.filter('currency', currency);
  },

};