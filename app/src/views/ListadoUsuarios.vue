<template>
  <v-app>
    <v-row>
      <v-col>
        <v-card
          elevation="10"
          shaped>
          <v-card-title>
            Listado de usuarios
          </v-card-title>
          <div>
            <!-- Contenido principal -->
            <div class="text-center">
              <!-- Tabla de usuarios -->
              <v-data-table
                :headers="headers"
                :items="listadoUsuario"
                :items-per-page="10"
                sort-by="NombreUsuario"
                class="elevation-1">
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
        </v-card>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>
import axios from "axios";

export default {
  name: "ListadoUsuarios",
  data: () => ({
    headers: [{
      text: 'id Usuario',
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
