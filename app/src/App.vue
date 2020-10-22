<template>
    <v-app>
      <!-- Barra de navegación -->
      <NavigationBar></NavigationBar>
      <v-main>
        <v-container>
          <router-view></router-view>
        </v-container>
      </v-main>
    </v-app>
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
