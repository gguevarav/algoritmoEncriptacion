<template>
  <div>
    <v-app>
      <v-content>
        <!-- Barra principal aplicación -->
        <AppBar></AppBar>
        <!-- Barra de navegación -->
        <NavigationBar></NavigationBar>
        <!-- Contenido principal -->
        <v-container>
          <router-view></router-view>
        </v-container>
      </v-content>
    </v-app>
  </div>
</template>

<script>

export default {
  name: 'App',

  components: {

  },

  data: () => ({

  }),
};
</script>
