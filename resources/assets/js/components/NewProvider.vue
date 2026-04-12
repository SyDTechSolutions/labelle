<template>
  <div class="card">
    <div class="card-body ">
        <form @submit.prevent="save()">
            
            <div class="form-row">
                <div class="form-group col-md-6">
                
                        <label for="tipo_identificacion">Tipo de identificación</label>
                        <select class="form-control custom-select" :class="errors.tipo_identificacion ? ' is-invalid' : ''" name="tipo_identificacion" id="tipo_identificacion" v-model="form.tipo_identificacion" >
                            <option value=""></option>
                            <option v-for="(value, key, index) in tipoIdentificaciones" :value="key" :key="key">
                                {{ value }}
                            </option>
                            
                            </select>
                            <form-error v-if="errors.tipo_identificacion" :errors="errors" style="float:right;">
                                {{ errors.tipo_identificacion[0] }}
                            </form-error>
                            
                </div>
                <div class="form-group col-md-6">
                    <label for="identificacion">Identificación</label>
                
                    <input type="text" class="form-control" :class="errors.identificacion ? ' is-invalid' : ''" id="identificacion" name="identificacion" placeholder="" v-model="form.identificacion">
                    
                    
                    <form-error v-if="errors.identificacion" :errors="errors" style="float:right;">
                        {{ errors.identificacion[0] }}
                    </form-error>
                    
                </div>
            </div>
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" :class="errors.name ? ' is-invalid' : ''" id="name" name="name" placeholder="" v-model="form.name">
                <form-error v-if="errors.name" :errors="errors" style="float:right;">
                    {{ errors.name[0] }}
                </form-error>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" :class="errors.email ? ' is-invalid' : ''" id="email" name="email" placeholder="" v-model="form.email">
                <form-error v-if="errors.email" :errors="errors" style="float:right;">
                    {{ errors.email[0] }}
                </form-error>
            </div>

            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" class="form-control" :class="errors.phone ? ' is-invalid' : ''" id="phone" name="phone" placeholder="" v-model="form.phone">
                <form-error v-if="errors.phone" :errors="errors" style="float:right;">
                    {{ errors.phone[0] }}
                </form-error>
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <textarea name="address" id="address" cols="30" rows="3" class="form-control" :class="errors.address ? ' is-invalid' : ''" v-model="form.address"></textarea>
                
                <form-error v-if="errors.address" :errors="errors" style="float:right;">
                    {{ errors.address[0] }}
                </form-error>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-default" @click="$emit('close')">Cancelar</button>
            </div>
            
        </form>
    </div>
  </div>
</template>
<script>
import FormError from "./FormError.vue";
 export default {
        props:['tipoIdentificaciones'],
        data() {
            return {
                form:{
                    
                },
                errors:[]
            }
        },
        components:{
            FormError
        },

        methods:{

            save() {
                axios.post(`/providers`, this.form)
                    .then(({data}) => {
                       
                        flash('El Proveedor ha sido creado.');
                        this.$emit('created', data);
                        this.form = {};
                    })
                     .catch(error => {
                        //flash(error.response.data.errors, 'danger');
                        this.errors = error.response.data ? error.response.data.errors : []
                    });
            },
          

        },
        
    }
</script>

