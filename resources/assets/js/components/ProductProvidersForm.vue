<template>
    <div class="invoice-form">
        <loading :show="loader"></loading>
        <form @submit.prevent="save()">
            <div class="row justify-content-between">
            
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Comparativa de Proveedores</div>

                            
                               
                        </div>
                        <div class="card">
                            <div class="card-header bg-default">Agregar Productos
                                <div class="input-group">
                                        
                                    <div class="input-group-prepend" v-if="!disableFields()">
                                        <button class="btn btn-outline-secondary" 
                                        type="button"
                                        data-toggle="modal"
                                        data-target="#productsModal"
                                        @click="showModalProducts()">Buscar</button>
                                    </div>
                                    <input type="text" class="form-control" id="codeProduct" placeholder="Codigo" v-model="code" @keydown.prevent.enter="searchProduct()" :disabled="disableFields()">
                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                           <tr>
                                                <th scope="col"></th>
                                                
                                                <!-- <th scope="col" title="Exonerar Linea">Exo.</th> -->
                                                <th scope="col">#</th>
                                                <th scope="col">Codigo</th>
                                                <th scope="col" style="width:250px;">Detalle</th>
                                                <th scope="col" style="width:50px;">Exist.</th>
                                                <th scope="col" style="width:50px;">Unids</th>
                                            
                                                <!-- <th scope="col">Medida</th> -->
                                                <th scope="col" style="width:110px;">Precio Compra.</th>
                                                
                                                <th style="width:40%;">Proveedores</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <tr v-for="(line, index) in productProvider.lines" :key="line.id">
                                                <td>
                                                    <button 
                                                        type="button" 
                                                        @click="removeLine(line, index)" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        v-if="!disableFields()"
                                                        >
                                                        <span class="oi oi-delete"></span>
                                                    </button>
                                                </td>
                                        
                                                <th scope="row">{{ index + 1 }}</th>
                                                <td>{{ line.Codigo }}</td>
                                                <td>{{ line.Detalle }}</td>
                                                <td>{{ line.existencias ? line.existencias : '--' }}</td>
                                                <td>
                                                    <input 
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        v-model="line.Cantidad"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields()"
                                                        >
                                                     <span v-else> {{ line.Cantidad }}</span>
                                                </td>
                                                
                                            
                                                <td>
                                                    <!-- <input 
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        v-model="line.PrecioUnitario"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields()"
                                                        > -->
                                                    <cleave 
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        v-model="line.PrecioUnitario"
                                                        :options="{ numeral: true}"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields()"
                                                        ></cleave>
                                                     <span v-else> {{ moneyFormat(line.PrecioUnitario) }}</span>
                                               
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info"
                                                @click="addFieldProvider(line, index)">Agregar Proveedor</button>
                                                    <div class="">
                                                         
                                                        <div class="input-group mb-3" v-for="(provider, indexProvider) in line.providers" :key="indexProvider">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" @click="removeFieldProvider(line, index, indexProvider)">x</span>
                                                            </div>
                                                            <!-- <input type="text" class="form-control" placeholder="Proveedor" aria-label="Username" aria-describedby="basic-addon1" v-model="provider.provider_name"> -->
                                                            <select name="provider_id" v-model="provider.id">
                                                                <option value="">-- Seleccione -- </option>
                                                                <option v-for="(provider, indexSelectProvider) in providers" :key="indexSelectProvider" :value="provider.id">
                                                                    {{ provider.name }}
                                                                </option>
                                                            </select>
                                                             <!-- <input type="text" class="form-control" placeholder="Precio"  v-model="provider.price"> -->
                                                             <cleave type="text" class="form-control" placeholder="Precio"  v-model="provider.price" :options="{ numeral: true}"></cleave>
                                                        </div>

                                                    </div>
                                                   
                                               
                                                </td> 
                                               
                                               
                                              
                                            </tr>
                                           
                                        </tbody>
                                        </table>
                                </div>
                               
                                
                            </div>
                        </div> <!--card productos-->

                         <div class="form-group buttons">
                            <button type="submit" class="btn btn-success" v-if="!disableFields()">Guardar</button>
                            <button type="button" class="btn btn-info" v-if="!disableFields()" @click="generateProformas()">Generar Proformas</button>
                            <a href="/productproviders" class="btn btn-light" role="button">Regresar</a>
                        </div>
                    </div>  <!--col-->
                   


          
            </div>

        </form>

        <!-- <providers-modal @assigned="addProvider" :tipo-identificaciones="tipoIdentificaciones"></providers-modal> -->
        <products-modal @assigned="addProduct" :providers="providers" :medidas="medidas" :taxes="taxes"></products-modal>
       

    </div>
    
</template>
<script>

import Loading from "./Loading.vue";
import ProvidersModal from "./ProvidersModal.vue";
import ProductsModal from "./ProductsModal.vue";
import FormError from "./FormError.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import Cleave from 'vue-cleave-component';

export default {
   props:['currentProductProvider','providers','tipoIdentificaciones','medidas','taxes'],
   data () {
       return {
           productProvider:{
                
               lines:[],
              
           },
          
           code:'',
           loader:false,
           errors:[],
           configDate:{
                dateFormat:'Y-m-d'
            },
           
           
           
       }
   },
   components:{
       ProvidersModal,
       ProductsModal,
       FormError,
       flatPickr,
       Loading,
       Cleave
   },
   
   methods:{
       
       disableFields(){
           
          return false//(this.productProvider.id)
       },
       
       moneyFormat(n){
         
           if(typeof n === "number"){

                return '₡' + n.format(2);
           }

           return '₡' + n;
       },
       
      
        showModalProducts(){
         
                 window.events.$emit('showProductsModal')
   
       },
      
       searchProduct(){
        
            axios.get(`/products?q=${this.code}`)
                .then(({data}) => {
                    if(data.data){
                        // this.addProduct(data.data)
                        // flash('Producto Agregado');
                        if(data.data.length == 1){
                            this.addProduct(data.data[0]);
                             flash('Producto Agregado');
                            this.scrollToEnd();
                        }else{
                              $('#productsModal').modal();
                            window.events.$emit('showProductsModal', { searchTerm: this.code})
                        }
                    }else{
                        flash('Producto No encontrado', 'danger');
                    }
                })
       },
        removeFieldProvider(line, index, indexProvider){
           
           line.providers.splice(indexProvider, 1);
       },
       addFieldProvider(line, index){
           
           let provider = {
                id : '',
                price: 0
           };

           line.providers.push(provider);
       },
       
      
       addProduct(product){
           this.createProductProviderLine(product)
           this.scrollToEnd();
          
       },
       removeLine(product, index){
            this.productProvider.lines.splice(index, 1);
            
       },

       createProductProviderLine(product){
          

             let lineIndexFound = _.findIndex( this.productProvider.lines, function(o) {
                    return o.Codigo === product.code;
             });
             let lineFound = _.find( this.productProvider.lines, function(o) {
                    return o.Codigo === product.code;
             });

             if(lineFound && lineIndexFound !== -1)
             {
                lineFound.Cantidad++
   
                this.updateProductProviderLine(lineFound, lineIndexFound);
                 
             }else{
               

                  let nuevo = {
                        Codigo: product.code,
                        Detalle: product.name,
                        existencias: product.quantity,
                        Cantidad: 0,
                        PrecioUnitario: product.purchase_price ? product.purchase_price : 0,
                        providers:[]
                      
                       
                    }
                  
              

                 this.productProvider.lines.push(nuevo);
             }

          

       },

       refreshLine(line, index){
          this.updateProductProviderLine(line, index);
          
       },

       updateProductProviderLine(line, index){
          
           this.productProvider.lines.splice(index, 1, line);
         
       },

      

      
       

       save(){
         if(!this.productProvider.lines.length){
                Swal({
                    title: 'lineas de detalle requerida',
                    html: 'Necesitar agregar al menos una linea para poder crear la factura',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Ok'
                }).then( (result) => {
    

                });

                return
        }

        this.persist();
           
       },
       persistProformas(productProviderData){
           this.loader = true;
           axios.post(`/productproviders/${productProviderData.id}/proformapurchases`, productProviderData)
                .then(({data}) => {
                    this.loader = false;
                    
                    flash('Proformas Guardadas Correctamente.');
                    this.$emit('created', data);

                    Swal({
                        title: 'Proformas Generadas',
                        html: 'Se generaron '+ data + ' Proformas',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        cancelButtonText: 'Ok',
                        confirmButtonText: 'Ir a proformas',
                       
                      
                    }).then( (result) => {
                        
                        if (result.value) {

                             window.location = '/proformapurchases'
                               
                        }else if (result.dismiss === Swal.DismissReason.cancel) {
                            
                               window.location = '/productproviders'
                            
                        }else{
                            
                            window.location = '/productproviders'

                        }


                        

                    });

                    

                  


                })
                .catch(error => {
                    this.loader = false;
                    flash('Error al guardar las proformas!!', 'danger');
                     this.errors = error.response.data.errors ? error.response.data.errors : [];
                });
       },
       generateProformas(){

                if(!this.productProvider.lines.length){
                    Swal({
                        title: 'lineas de detalle requerida',
                        html: 'Necesitar agregar al menos una linea para poder crear la comparativa',
                        showCancelButton: false,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        cancelButtonText: 'No',
                        confirmButtonText: 'Ok'
                    }).then( (result) => {
        

                    });

                    return
            }

            if(this.productProvider.id){

                this.persistProformas(this.productProvider);


           }else{
               this.loader = true;
                axios.post(`/productproviders`, this.productProvider)
                .then(({data}) => {
                    this.loader = false;
                    this.persistProformas(data);

                })
                .catch(error => {
                    this.loader = false;
                    flash('Error al guardar la orden de compra!!', 'danger');
                     this.errors = error.response.data.errors ? error.response.data.errors : [];
                });

           }
       },
       persist(){
           if(this.productProvider.id){

                axios.put(`/productproviders/${this.productProvider.id}`, this.productProvider)
                    .then(({data}) => {
                        
                        //this.clearForm();
                        flash('Comparativa Guardada Correctamente.');
                        this.$emit('updated', data);
                            
                       


                    })
                    .catch(error => {
                        flash('Error al guardar la Comparativa!!', 'danger');
                         this.errors = error.response.data.errors ? error.response.data.errors : [];
                    });

           }else{

                axios.post(`/productproviders`, this.productProvider)
                .then(({data}) => {
                    
                    this.clearForm();
                    flash('Comparativa Guardada Correctamente.');
                    this.$emit('created', data);

                    if(data.id){
                        window.location = '/productproviders/'+ data.id;
                    }
                    


                })
                .catch(error => {

                    flash('Error al guardar la Comparativa!!', 'danger');
                     this.errors = error.response.data.errors ? error.response.data.errors : [];
                });

           }
          
       },
      
   
     
       clearForm(){

           this.productProvider = {

               lines:[]
               
           };

           this.code = '';
           
           
            

       },
       scrollToEnd(){
            let target = $('.buttons');
            if( target.length ) {
                
                $('html, body').stop().animate({
                    scrollTop: target.offset().top
                }, 500);
            }
       }
       
   },
   created(){
       if(this.currentProductProvider){
           this.productProvider = this.currentProductProvider;
          
           this.productProvider.lines.forEach((line, index) => {
               
               this.refreshLine(line, index);
           });
           
       }
   }

}
</script>
