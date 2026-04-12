<template>
  <div class="loader" :class="(show) ? 'show' : ''" :style="(positionCss) ? 'position:'+ positionCss + ';' : ''">
        <div class="img" :class="show">
        <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        <span><slot>Cargando...</slot></span>
        </div>
        
    </div>
</template>
<script>
export default {
    props:['show', 'positionCss']
}
</script>