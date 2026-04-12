<template>
   <div class="modal fade" id="paymentsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="paymentsModalLabel">Abonos de la factura {{ purchase.consecutivo }}</h4>
                </div>
                <div class="modal-body">
                   
                        <new-purchase-payment @created="add" :purchase="purchase"></new-purchase-payment>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>FECHA</th>
                                    <th>MONTO</th>
                                    <!-- <th>MODO PAGO</th> -->
                                    <th>COMPROBANTE</th>
                                    <th></th>
                                
                                
                                </tr>
                            </thead>
                            <tbody>
                               
                                
                                <tr v-for="(payment, index) in items" :key="payment.id">
                                    
                                    <td>{{ payment.created_at }}</td>
                                    <td>{{ moneyFormat(payment.amount) }}</td>
                                    <!-- <td>{{ payment.modoPago }}</td> -->
                                    <td>{{ payment.comprobante }}</td>
                                    <td>
                                      <button class="btn btn-danger" @click="destroy(payment, index)">Eliminar</button>
                                    </td>
                            
                                </tr>
                                 <tr>
                                    <td>Monto Cuenta</td>
                                    <td colspan="4"> {{ moneyFormat(parseFloat(purchase.TotalComprobante)) }}</td>
                                    
                                </tr>
                                <tr class="table-success">
                                    <td>Total Abonos</td>
                                    <td colspan="4"> {{ moneyFormat(total()) }}</td>
                                    
                                </tr>
                                 <tr class="table-danger">
                                    <td>Pendiente</td>
                                    <td colspan="4"> {{ moneyFormat(pending()) }}</td>
                                    
                                </tr>
                          
                                
                            </tbody>
                        </table>
                         <paginator :dataSet="dataSet" @changed="fetch" :noUpdateUrl="true"></paginator>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" @click="print()">IMPRIMIR</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NewPurchasePayment from './NewPurchasePayment.vue'
    import collection from '../mixins/collection'


    export default {
     
        data() {
            return {
                dataSet: false,
                q: '',
                purchaseId: false,
                purchase:false
               
                
            }
        },
        components:{
          NewPurchasePayment
        },
        mixins:[collection],

        methods:{

            total(){
                return _.sumBy(this.items, function(o) { return o.amount; });
            },
            pending(){
                return parseFloat(this.purchase.TotalComprobante) - this.total()
            },
            moneyFormat(n){
         
                if(typeof n === "number"){

                        return '₡' + n.format(2);
                }

                return '₡' + n;
            },

            print(){
                //window.open(`/cxc/${this.purchaseId}/print`,'_blank');
               window.location = `/cxp/${this.purchaseId}/print`;
            },

            fetch(page){
                axios.get(this.url(page))
                .then(this.refresh)
            },

            url(page){
                let url =`/purchases/${this.purchaseId}/payments`;

                if (! page) {
                    //let query = location.search.match(/page=(\d+)/);
                    page = 1;//query ? query[1] : 1;
                }
                
                url = `${url}?page=${page}`;

                if(this.q){
                    url += `&q=${this.q}`
                }
                 

                return url;
            },

            refresh({data}){

             
                this.dataSet = data;
                this.items = data.data;

            },
             destroy(item, index) {
                axios.delete(`/purchasepayments/${item.id}`);
                this.remove(index);
            },
            getPurchase(){
                 axios.get(`/purchases/${this.purchaseId}`)
                .then( ({data}) =>{
                    this.purchase = data;
                })
            }

        },
        created(){

           window.events.$on('showPaymentsModal', (data) => {
               this.purchaseId = data;
               this.getPurchase();
               this.fetch();
           });


        }
      
    }
</script>

