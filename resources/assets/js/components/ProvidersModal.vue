<template>
   <div class="modal fade" id="providersModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="providersModalLabel">Proveedores</h4>
                    <button type="button" @click="createProvider = true" class="btn btn-success">Crear</button>
                </div>
                <div class="modal-body">
                    <new-provider v-show="createProvider" @created="agregar" @close="createProvider = false" :tipo-identificaciones="tipoIdentificaciones"></new-provider>
                    <div v-show="!createProvider">
                         <div class="row">
                            <div class="col-sm-12">
                            <input type="search" class="form-control input-sm" v-model="q" @keyup.enter="search" placeholder="Buscar...">
                            </div>
                                            
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        
                                        <th>NOMBRE</th>
                                        <th>EMAIL</th>
                                        <th></th>
                                    
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    <tr class="no-items" v-if="!items.length" >
                                        <td colspan="3">No existes elementos con esta busqueda.. Puedes crearlo si lo deseas <button type="button" @click="createProvider = true" class="btn btn-success">Crear</button>
                                    </td>
                                    </tr>
                                    <tr v-for="provider in items" :key="provider.id" @click="assign(provider)">
                                        
                                        <td>{{ provider.name }}</td>
                                        <td>{{ provider.email }}</td>
                                        <td>
                                        <button class="btn btn-primary" @click="assign(provider)">Agregar</button>
                                        </td>
                                
                                    </tr>
                            
                                    
                                </tbody>
                            </table>
                            <paginator :dataSet="dataSet" @changed="fetch" :noUpdateUrl="true"></paginator>
                        </div>

                    </div>
                    
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-link waves-effect btn-close-modal" data-dismiss="modal" @click="q = ''">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import collection from '../mixins/collection'
    import NewProvider from './NewProvider.vue'

    export default {
        props:['tipoIdentificaciones'],
        data() {
            return {
                dataSet: false,
                q: '',
                providerId: false,
                createProvider:false
            }
        },
        components:{
          NewProvider
        },
        mixins:[collection],
        methods:{
            agregar(item){
                this.add(item);
                this.createProvider = false;
            },
            assign(item){
                console.log(item)
                this.$emit('assigned', item)
                $(this.$el).find('.btn-close-modal').click();
            },
           
            search(){
              
                this.fetch()
              
            },

            fetch(page){
                axios.get(this.url(page))
                .then(this.refresh)
            },

            url(page){
                let url =`/providers`;

                if (! page) {
                    //let query = location.search.match(/page=(\d+)/);
                    page = 1;//query ? query[1] : 1;
                }
                
                url = `/providers?page=${page}`;

                if(this.q){
                    url += `&q=${this.q}`
                }
                 

                return url;
            },

            refresh({data}){

             
                this.dataSet = data;
                this.items = data.data

            }

        },
        created(){

            //this.fetch()

           window.events.$on('showProvidersModal', (data) => {
              if(data && data.searchTerm){
                  this.q = data.searchTerm;
              }
               this.fetch()
           });


        }
      
    }
</script>

