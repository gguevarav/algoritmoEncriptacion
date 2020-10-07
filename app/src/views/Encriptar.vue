<template>
  <v-app>
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
    <v-card>
      <v-card-title>
        <span
          class="headline">
          Encriptar una contraseña
        </span>
      </v-card-title>
      <v-card-text>
        <v-form>
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
                sm="6"
                md="6">
                <v-text-field
                  v-model="DatosUsuario.NombreApellidoUsuario"
                  label="NombreUsuario"
                  :rules="[rules.required]">
                </v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6">
                <v-text-field
                  v-model="DatosUsuario.ContraseniaUsuario"
                  label="Contraseña"
                  :rules="[rules.required]">
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="blue darken-1"
          text
          @click="guardarInformacion()">
          Encriptar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-app>
</template>

<script>
import axios from "axios";

export default {
  name: "Encriptar",
  data: () => ({
    snackbar: false,
    textoSnackbar: '',
    timeout: 3000,
    alertaErrores: false,
    listadoErrores: [],
    DatosUsuario:{
      NombreApellidoUsuario: '',
      ContraseniaUsuario: '',
    },
    datosVacios:{
      NombreApellidoUsuario: '',
      ContraseniaUsuario: '',
    },
    rules: {
      required: value => !!value || 'Campo requerido.',
      min: v => v.length >= 8 || '8 caracteres como mínimo',
      counter: value => value.length <= 20 || 'Max 20 characters',
    },
  }),
  methods:{
    guardarInformacion(){
      new Promise((resolve, reject) => {
        axios
          .post("/usuarios", this.DatosUsuario)
          .then(response => {
            // Si la respuesta es 200 significa que los datos fueron almacenados correctamente
            if (response.data.status == 200) {
              // Mostramos la confirmación
              this.alertaErrores = false
              this.textoSnackbar = 'Contraseña encriptada exitosamente'
              this.snackbar = !this.snackbar
              this.DatosUsuario = Object.assign({}, this.datosVacios)
            }
            // Se la respuesta es 404 es que los datos contienen errores
            else if (response.data.status == 404) {
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
