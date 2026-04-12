<template>
   <div class="modal fade" id="productsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="productsModalLabel">Productos</h4>
                </div>
                <div class="modal-body">
                     <div class="row">
                        <div class="col-sm-12" style="display: flex; gap:10px;">
                           <input type="search" class="form-control input-sm" v-model="q" @keyup.enter="search" placeholder="Buscar...">
                           <select class="form-control custom-select" name="precision" id="precision" v-model="precision" style="width: 150px;">
                                <option value="preciso">Preciso</option>
                                <option value="coincidencias">Coincidencias</option>                                        
                            </select>
                        </div>
                                        
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th>EXISTENCIAS</th>
                                    <th>PRECIO</th>
                                    <th></th>
                                
                                
                                </tr>
                            </thead>
                            <tbody>
                               
                                
                                <tr v-for="product in items" :key="product.id">
                                    <td>{{ product.code }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.quantity }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>
                                      <button class="btn btn-primary" @click="assign(product)">Agregar</button>
                                    </td>
                            
                                </tr>
                          
                                
                            </tbody>
                        </table>
                         <paginator :dataSet="dataSet" @changed="fetch" :noUpdateUrl="true"></paginator>
                    </div>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
        <div id="imageProductModal" 
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
            <span @click="closeModal()" 
                style="position: absolute; top: 20px; right: 30px; color: white; font-size: 30px; cursor: pointer;">&times;</span>
            <img id="modalProductImage" 
                style="max-width: 90%; max-height: 90%; border-radius: 10px;">
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
                precision: 'preciso',
                productId: false
                
            }
        },
        components:{
          
        },
        mixins:[collection],

        methods:{

            assign(item){
                this.$emit('assigned', item)
            },
           
            search(){
              
                this.fetch()
              
            },

            fetch(page){
                axios.get(this.url(page))
                .then(this.refresh)
            },

            url(page){
                let url =`/products`;

                if (! page) {
                    //let query = location.search.match(/page=(\d+)/);
                    page = 1;//query ? query[1] : 1;
                }
                
                url = `/products?page=${page}`;

                if(this.q){
                    url += `&q=${this.q}&precision=${this.precision}`
                }
                 

                return url;
            },

            refresh({data}){
                this.dataSet = data;
                this.items = data.data 
            },
            getPhotoPath(url){
                let path = document.location.origin+'/storage/'+url
                return path
            },
            showImage(src) {
                let modal = document.getElementById('imageProductModal');
                let modalImage = document.getElementById('modalProductImage');
                modalImage.src = src;
                modal.style.display = 'flex'; // Muestra el modal
            },
            closeModal() {
                let modal = document.getElementById('imageProductModal');
                modal.style.display = 'none'; // Oculta el modal
            }

        },
        created(){

            //this.fetch()

           window.events.$on('showProductsModal', (data) => {
               //this.productId = data
               this.fetch()
           });


        }
      
    }
</script>

