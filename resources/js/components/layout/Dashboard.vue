<template>
  <v-container fluid class="pt-0">
    <v-row>
      <v-col cols="12" sm="12" md="4" class="d-flex">  
        <v-card v-if="render" class="shadow-small round">
          <v-card-title primary-title>
            Asistencias de empleados
          </v-card-title>
          <v-card-text>
            <apexchart 
              type="radialBar" 
              height="350" 
              :options="chartOptions_radial" 
              :series="series_radial"
            ></apexchart>            
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="4" class="d-flex">  
        <v-card v-if="render" class="shadow-small round">
          <v-card-title primary-title>
            Vacaciones
          </v-card-title>
          <v-card-text>
            <apexchart 
              type="bar" 
              height="350" 
              :options="chartOptions_bar" 
              :series="series_bar"
            ></apexchart>           
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="4" class="d-flex">  
        <!-- <v-card class="shadow-small round" height="100%"> -->
        <v-card v-if="render" class="shadow-small round">
          <v-card-title primary-title>
            Empleados de permisos
          </v-card-title>
          <v-card-text>
            <apexchart 
              type="area" 
              height="350" 
              :options="chartOptions_area" 
              :series="series_area"
            ></apexchart>           
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import Swal from 'sweetalert2';
import VueApexCharts from "vue-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts
  },
  data() {
    return {
      render: false,
      series_radial: [44, 55, 67],
      chartOptions_radial: {
        chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function (w) {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return 249
                }
              }
            }
          }
        },
        labels: [ 'Año', 'Mes', 'Dia',],
      },
      series_bar: [{
            // name: 'Servings',
            data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31, 87, 65]
      }],
      chartOptions_bar: {
        chart: {
          height: 350,
          type: 'bar',
          toolbar: {
            show: false
          }
        },
        plotOptions: {
          bar: {
            columnWidth: '50%',
            endingShape: 'rounded',
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: 2
        },
        
        grid: {
          row: {
            colors: ['#fff', '#f2f2f2']
          }
        },
        xaxis: {
          labels: {
            rotate: -45
          },
          categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre','Octubre', 'Noviembre', 'Diciembre'],
          tickPlacement: 'on'
        },
        yaxis: {
          // title: {
          //   text: 'Servings',
          // },
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.85,
            stops: [50, 0, 100]
          },
        }
      },
      series_area: [{
          name: 'series1',
          data: [31, 40, 28, 51, 42, 109, 100]
      }],
      chartOptions_area: {
        chart: {
          height: 350,
          type: 'area',
          toolbar: {
            show: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
      },
          
          
    }
  },
  mounted() {
    this.render = true
  },
  computed: {
  },
  created() {
  },
  methods: {
    
  }
}
  
</script>
<style>
  
</style>