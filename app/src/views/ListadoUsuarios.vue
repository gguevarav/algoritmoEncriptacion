<template>
  <v-app>
    <div>
      <!-- Contenido principal -->
      <div class="text-center">
        <!-- Tabla de usuarios -->
        <v-data-table
          :headers="headers"
          :items="listadoUsuario"
          :items-per-page="5"
          sort-by="NombreUsuario"
          class="elevation-1">
          <template
            v-slot:top>
            <v-toolbar
              flat
              color="white">
              <v-toolbar-title>
                Listado de usuarios
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <!-- Termina dialog de botones de agregar y recargar -->
            </v-toolbar>
          </template>
          <template
            v-slot:item.actions="{ item }">
            <v-icon
              small
              class="mr-2"
              @click="agregarProductoInventario(item, item.idInventario)">
              mdi-plus
            </v-icon>
            <v-icon
              small
              class="mr-2"
              @click="editarMinimosMaximosProducto(item, item.idInventario)">
              mdi-pencil
            </v-icon>
          </template>
        </v-data-table>
        <!-- Termina tabla de usuarios -->
      </div>
    </div>
  </v-app>
</template>

<script>
import axios from "axios";

export default {
  name: "ListadoUsuarios",
  data: () => ({
    headers: [{
      text: 'idUsuarios',
      align: 'start',
      sortable: false,
      value: 'idUsuario',
    },
      {
        text: 'Nombre y apellido',
        value: 'NombreApellidoUsuario'
      },
      {
        text: 'Contraseña',
        value: 'ContraseniaUsuario'
      },
      {
        text: 'Contraseña encriptada',
        value: 'ContraseniaEncriptada'
      },
    ],
    listadoUsuario: [],
  }),
  created() {
    this.initialize()
  },
  methods: {
    initialize(){
      new Promise((resolve, reject) => {
        axios.get("/usuarios")
          .then(response => {
            if (response.data.total != 0){
              this.listadoUsuario = response.data.detalle
            }
          })
        .catch(function (error){
          console.log(error);
        })
      });
    },
  },
}
</script>

<style scoped>

</style>
