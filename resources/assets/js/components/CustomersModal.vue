<template>
   <div class="modal fade" id="customersModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="customersModalLabel">Clientes</h4>
                </div>
                <div class="modal-body">
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
                               
                                
                                <tr v-for="customer in items" :key="customer.id">
                                    
                                    <td>{{ customer.name }}</td>
                                    <td>{{ customer.email }}</td>
                                    <td>
                                      <button class="btn btn-primary" @click="assign(customer)">Agregar</button>
                                    </td>
                            
                                </tr>
                          
                                
                            </tbody>
                        </table>
                         <paginator :dataSet="dataSet" @changed="fetch" :noUpdateUrl="true"></paginator>
                    </div>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-link waves-effect btn-close-modal" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import collection from '../mixins/collection'


    export default {
     
        data() {
            return {
                dataSet: false,
                q: '',
                customerId: false
                
            }
        },
        components:{
          
        },
        mixins:[collection],

        methods:{

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
                let url =`/customers`;

                if (! page) {
                    //let query = location.search.match(/page=(\d+)/);
                    page = 1;//query ? query[1] : 1;
                }
                
                url = `/customers?page=${page}`;

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

           window.events.$on('showCustomersModal', (data) => {
               //this.customerId = data
               this.fetch()
           });


        }
      
    }
</script>

