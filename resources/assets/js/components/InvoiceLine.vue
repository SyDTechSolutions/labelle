<template>
  <tr>
    <th scope="row">1</th>
    <td>{{ line.Codigo }}</td>
    <td>{{ line.Detalle }}</td>
    <td>{{ line.Cantidad }}</td>
    <td>{{ line.UnidadMedida }}</td>
    <td>{{ line.PrecioUnitario }}</td>
  </tr>

</template>
<script>
export default {
  
  props:['line'],

  data(){
      return {
        items: []
      }
  }
}
</script>
