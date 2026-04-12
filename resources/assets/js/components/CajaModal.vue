<template>
   <div class="modal fade" id="cajaModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="cajaModalLabel">Caja </h4>
                </div>
                <div class="modal-body">
                   <form @submit.prevent="save()">
            
                    <div class="form-row">
                            <div class="form-group col-md-12">
                            <label for="amount">Monto</label>
                            
                            <input type="text" class="form-control" id="amount" placeholder="" v-model="amount">
                            <form-error v-if="errors.amount" :errors="errors" style="float:right;">
                                {{ errors.amount[0] }}
                            </form-error>    
                            
                        </div>
                    
                       
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    
                
                    
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-link waves-effect btn-close-modal" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
   
    export default {
    
        data() {
            return {
                amount: 0,
                errors:[],
                caja: false
    
            }
        },

        methods:{

            save(){
                if(this.caja){
                     axios.put('/cajas/'+ this.caja.id,{ amount: this.amount})
                    .then(({data}) => {
                        flash('Monto Actualizado')
                        $(this.$el).find('.btn-close-modal').click();
                    }).catch(error =>{
                        flash('Error Al Actualizar Monto', 'danger')
                        this.errors = error.response.data ? error.response.data.errors : []
                    });
                }else{

                    axios.post('/cajas',{ amount: this.amount})
                    .then(({data}) => {
                        flash('Monto Agregado')
                        $(this.$el).find('.btn-close-modal').click();
                    }).catch(error =>{
                        flash('Error Al guardar Monto', 'danger')
                        this.errors = error.response.data ? error.response.data.errors : []
                    });

                }
                

               
            },
            fetch(){
                axios.get('/cajas/today')
                .then(({data}) =>{
                    if(data){

                        this.caja = data
                        this.amount = this.caja.amount
                    }
                })
            }
           

        },
        created(){

       
            window.events.$on('showCajaModal', (data) => {
                
              this.fetch()
           });


        }
      
    }
</script>

