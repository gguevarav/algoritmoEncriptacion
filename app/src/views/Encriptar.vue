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
    <v-col cols="12">
      <v-card
        elevation="10"
        shaped>
        <v-card-title>
          <span>
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
                  sm="12"
                  md="4">
                  <v-text-field
                    v-model="DatosUsuario.NombreApellidoUsuario"
                    label="Nombre del usuario"
                    :rules="[rules.required]">
                  </v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="4">
                  <v-text-field
                    v-model="DatosUsuario.ContraseniaUsuario"
                    label="Contraseña"
                    :rules="[rules.required]">
                  </v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="4">
                  <v-text-field
                    v-model="DatosUsuario.llaveEncriptacion"
                    label="Llave de encriptado"
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
            text
            @click="guardarInformacion()">
            Encriptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-col
      cols="12">
      <div>
        <v-card
          elevation="10"
          shaped
          v-if="mostrarContraseniaEncriptada">
          <v-card-title>
            Contraseña encriptada
          </v-card-title>
          <v-card-subtitle>
            Esta es tu contraseña encriptada, puede copiarla al portapapeles
          </v-card-subtitle>
          <v-card-text>
            <v-text-field
              ref="contraseniaEncript"
              :value="contreseniaEncriptada"
              append-icon="mdi-clipboard"
              @click:append="copyToClipboard(contreseniaEncriptada)">
            </v-text-field>
          </v-card-text>
        </v-card>
      </div>
    </v-col>
  </v-row>
  </div>
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
    contreseniaEncriptada: '',
    mostrarContraseniaEncriptada: false,
    DatosUsuario:{
      NombreApellidoUsuario: '',
      ContraseniaUsuario: '',
      llaveEncriptacion: '',
    },
    datosVacios:{
      NombreApellidoUsuario: '',
      ContraseniaUsuario: '',
      llaveEncriptacion: '',
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
              //console.log(response.data)
              this.mostrarContraseniaEncriptada = true;
              this.contreseniaEncriptada = response.data.contreseniaEncriptada;
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
    },
    copyToClipboard(value) {
      try {

        // Creates the input if it doesn't exist.
        let ghostExists = (document.querySelector('.app-ghost-clipboard') !== null)
        let ghostInput = !ghostExists ? document.createElement('input') : document.querySelector('.app-ghost-clipboard')

        // Style it so it doesn't interfere with layout.
        ghostInput.style.position = 'fixed'
        ghostInput.style.top = 0
        ghostInput.style.left = 0
        ghostInput.style.padding = 0
        ghostInput.style.margin = 0
        ghostInput.style.width = '2em'
        ghostInput.style.height = '2em'
        ghostInput.style.border = 'none'
        ghostInput.style.outline = 'none'
        ghostInput.style.boxShadow = 'none'
        ghostInput.style.background = 'transparent'
        ghostInput.style.color = 'transparent'

        // First time setup for ghost input.
        if(!ghostExists) {
          ghostInput.className = 'app-ghost-clipboard'
          ghostInput.setAttribute('type', 'text')
          document.documentElement.appendChild(ghostInput)
        }

        // Assign value to input - select,copy,blur,catch errs
        ghostInput.value = value
        ghostInput.select()

        document.execCommand('copy')
        // Mostramos la confirmación
        this.textoSnackbar = 'Contraseña copiada al portapapeles'
        this.snackbar = !this.snackbar
        ghostInput.blur()
      } catch(err) {
        console.error('No copy to clipboard support present.')
        throw err
      }
    },
  },
}
</script>

<style scoped>

</style>
