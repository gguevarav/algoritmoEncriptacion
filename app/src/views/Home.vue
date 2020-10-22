<template>
  <div
    class="home">
    <v-card
      elevation="10"
      shaped>
      <v-card-title>
        <h1>Análisis de sistemas II</h1>
      </v-card-title>
      <v-card-subtitle>
        <h2>Análisis y diseño No. 5</h2>
      </v-card-subtitle>
      <v-card-text>
        <h3>INSTRUCCIONES</h3>
        <p>Utilizando  los recursos proporciondos por la Universidad, crear un servidor con Arquitectura Sobre servicios en Windows Azure.</p>
        <p>En base al siguiente requerimiento realizar una aplcación Web de Encriptación de datos</p>
        <ol>
          <li>Algoritmo AES (Advanced Encryption Standard)</li>
        </ol>
        <h3>Requerimiento</h3>
        <ul>
          <li>R1 Encriptar datos.</li>
          <li>R2 Desencriptar datos.</li>
          <li>R3 Los datos encriptados deben de almacenarse en una tabla de base de datos, donde almacene</li>
          <ul>
            <li>Nombre de Usuario.</li>
            <li>Contraseña</li>
            <li>Contraseña Encriptada</li>
          </ul>
          <li>R4: Los datos: Nombre , Contraseña y Contraseña Encriptada , deben de ser presentados en Grid de la aplicación.</li>
          <li>R5: Presentar URL para probar servicio.</li>
        </ul>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>

export default {
  name: 'Home',
}
</script>
