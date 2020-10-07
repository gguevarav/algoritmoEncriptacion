<template>
  <v-navigation-drawer v-model="barraNavegacion" app floating :permanent="barraNavegacion" dark>
    <v-list>
      <v-list-item>
        <v-list-item-avatar>
          <v-img src="../assets/images/nouser.png" height="752" width="860"/>
        </v-list-item-avatar>
      </v-list-item>

      <v-list-group link>
        <template v-slot:activator>
          <v-list-item-content>
            <v-list-item-title class="title">admin</v-list-item-title>
            <v-list-item-subtitle>admin@admin.com</v-list-item-subtitle>
          </v-list-item-content>
        </template>
      </v-list-group>
    </v-list>
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
    barraNavegacion: true,
  })
}
</script>
