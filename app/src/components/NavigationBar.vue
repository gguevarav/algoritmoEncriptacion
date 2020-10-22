<template>
  <v-div>
    <v-app-bar color="brown darken-3" dark app>
      <v-app-bar-nav-icon
        @click="barraNavegacion = !barraNavegacion">
      </v-app-bar-nav-icon>
      <v-toolbar-title>
        Encriptador de contraseñas
      </v-toolbar-title>
    </v-app-bar>
    <v-navigation-drawer
      color="teal darken-4"
      v-model="barraNavegacion"
      app
      floating
      dark>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Encriptador
          </v-list-item-title>
          <v-list-item-subtitle>
            AES-256-CBC
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
      <v-list nav dense flat>
        <v-list-item-group>
          <v-list-item :to="{name: 'home'}">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Inicio</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item :to="{name: 'encriptar'}">
            <v-list-item-icon>
              <v-icon>mdi-qrcode</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Encriptar</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item :to="{name: 'desencriptar'}">
            <v-list-item-icon>
              <v-icon>mdi-qrcode-scan</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Desencriptar</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item :to="{name: 'listadousuarios'}">
          <v-list-item-icon>
            <v-icon>mdi-account-multiple</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Listado de usuarios</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

          <v-list-item :to="{name: 'about'}">
            <v-list-item-icon>
              <v-icon>mdi-help</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Acerca de</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </v-div>
</template>

<script>

import { mapState } from 'vuex'

export default {

  computed: {
    mini () {
      return (this.$vuetify.breakpoint.smAndDown) || this.toggleMini
    }
  },
  data: () => ({
    barraNavegacion: false,
  })
}
</script>
