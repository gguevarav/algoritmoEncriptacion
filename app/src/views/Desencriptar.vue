<template>
  <div>
  <div>
    <!-- Snackbar de notificaciones -->
    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
      color="success">

      {{ textoSnackbar }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="blue darken-1"
          text
          v-bind="attrs"
          @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
    <!-- Termina Snackbar de notificaciones -->
  </div>
  <v-row>
    <v-col>
      <v-card
        elevation="10"
        shaped>
        <v-card-title>
          <span>
            Desencriptar una contraseña
          </span>
        </v-card-title>
        <v-card-text>
          <v-form
            ref="formulario">
            <v-alert
              type="error"
              v-model="alertaErrores">
              Los registros contienen los siguientes errores:
              <li
                v-for="value in listadoErrores"
                v-bind:key>
                {{ value }}
              </li>
            </v-alert>
            <v-container>
              <v-row>
                <v-col
                  cols="12"
                  sm="12"
                  md="4">
                  <v-text-field
                    v-model="DatosUsuario.ContraseniaEncriptada"
                    label="Contrasenia encriptada"
                    :rules="[rules.required]">
                  </v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="4">
                  <v-text-field
                    v-model="DatosUsuario.llaveEncriptacion"
                    label="Clave de encriptación"
                    :rules="[rules.required]">
                  </v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="4">
                  <v-text-field
                    v-model="DatosUsuario.ContraseniaUsuario"
                    label="Contrasenia desencriptada">
                  </v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            text
            @click="enviarInformacion()">
            Desencriptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Desencriptar",
  data: () => ({
    snackbar: false,
    textoSnackbar: '',
    timeout: 3000,
    alertaErrores: false,
    listadoErrores: [],
    DatosUsuario:{
      ContraseniaEncriptada: '',
      ContraseniaUsuario: '',
      llaveEncriptacion: '',
    },
    datosVacios:{
      ContraseniaEncriptada: '',
      ContraseniaUsuario: '',
      llaveEncriptacion: '',
    },
    contraseniaDesencriptada: [],
    rules: {
      required: value => !!value || 'Campo requerido.',
      min: v => v.length >= 8 || '8 caracteres como mínimo',
      counter: value => value.length <= 20 || 'Max 20 characters',
    },
  }),
  methods:{
    enviarInformacion(){
      new Promise((resolve, reject) => {
        axios
          .post("/desencriptar", this.DatosUsuario)
          .then(response => {
            //console.log(response.data)
            // Si la respuesta es 200 significa que los datos fueron almacenados correctamente
            if (response.data.status == 200) {
              // Mostramos la confirmación
              this.alertaErrores = false
              this.textoSnackbar = 'Contraseña desencriptada exitosamente'
              this.snackbar = !this.snackbar
              this.DatosUsuario.ContraseniaUsuario = response.data.ContraseniaUsuario
              //this.$refs.formulario.reset()
              //this.DatosUsuario = Object.assign({}, this.datosVacios)
              //console.log(response.data)
            }
            // Se la respuesta es 404 es que los datos contienen errores
            else if (response.data.status == 404) {
              //console.log(response.data)
              this.listadoErrores = response.data.errores
              this.alertaErrores = true
            }
          })
          .catch(function (error) {
            console.log(error);
          })
      });
    }
  },
}
</script>

<style scoped>

</style>
