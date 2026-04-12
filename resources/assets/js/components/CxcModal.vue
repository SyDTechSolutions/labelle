<template>
   <div class="modal fade" id="cxcModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="cxcModalLabel">Cuenta {{ customer.name }}</h4>
                </div>
                <div class="modal-body">
                   
                    
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!--Se agregaron nuevas columnas-->
                                    <th>#Fac</th>
                                    <th>F.Emisión</th>
                                    <th>F.Vencimiento</th>
                                    <th>Débito</th>
                                    <th>F.Abono</th>
                                    <th>Crédito</th>
                                    <th>Saldo</th>
                                    <th>D.Vencidos</th>   
                                
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr v-for="(item, index) in items" :key="item.id">
                                    <!--Valida si es una factura o abono-->                                    
                                    <th v-if="item.type === 'D'">{{ item.description }}</th>
                                    <th v-else></th>

                                    <td v-if="item.type === 'D'">{{ item.date }}</td>
                                    <th v-else></th>

                                    <th>{{item.dateVen}}</th>

                                    <th  v-if="item.type === 'D'">{{  moneyFormat(item.amount, '') }}</th>
                                    <th v-else></th>

                                    <th v-if="item.type === 'C'">{{ item.date }}</th>
                                    <th v-else></th>

                                    <td v-if="item.type === 'D'">{{getCredito(item.factura,item.type)}}</td>
                                    <th v-else>{{moneyFormat(item.amount, '')}}</th>

                                    <th  v-if="item.type === 'D'">{{getSaldo(item.factura)}}</th>
                                    <th v-else></th>

                                     <th  v-if="item.type === 'D'">{{dVencidos(item.dateVen)}}</th>
                                    <th v-else></th> 
                                              
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <th>Total</th>
                                    <th> {{ moneyFormat(parseFloat(customer.TotalCxc)) }}</th>
                                    
                                </tr>
                                
                          
                                
                            </tbody>
                        </table>
                         <paginator :dataSet="dataSet" @changed="fetch" :noUpdateUrl="true"></paginator>
                    </div>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-link waves-effect" @click="print()">IMPRIMIR</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" @click="clear()">CERRAR</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import NewPayment from './NewPayment.vue'
    import collection from '../mixins/collection'


    export default {
     
        data() {
            return {
                dataSet: false,
                q: '',
                customerId: false,
                customer:false,
                factura:[],
                tipo:''
                
            }
        },
        components:{
         // NewPayment
        },
        mixins:[collection],

        methods:{
            //Saca los días vencidos de cada factura
            dVencidos(feVen){
                let today = new Date().toISOString().slice(0,10);
                let fechaTod = new Date(today);
                let fechaVen = new Date(feVen);
                let miliTrans = Math.abs(fechaTod.getTime()-fechaVen.getTime());
                let diasTrans = Math.round(miliTrans/86400000);
                if(today > feVen){
                    return diasTrans;
                }else{

                    return 0;
                }
                
                return 0;
            },//Limpia la factura cada vez que cierran el modal
            clear(){
                this.factura = [];
            },//Ordena el array por factura, para así tener sus respectivos abonos abajo
            compare(a,b){
                if ( a.factura < b.factura ){
                    return -1;
                }
                if ( a.factura > a.factura ){
                    return 1;
                }
                return 0;
            },//Agrega en el array factura si es una factura, sino agrega la cantidad del abono para el credito 
            credito(items){
                let x,y;
                for(x in items){
                    if(items[x].type=='D'){
                        this.factura.push({num:items[x].factura,credito:0,debito:items[x].amount});
                    }else{
                        for(y in this.factura){
                            if(this.factura[y].num == items[x].factura){
                                this.factura[y].credito -= items[x].amount;
                            }
                        }
                    }
                }
                
            },//Obtiene el credito que tiene guardado el array de factura
            getCredito(numFactura,tipo){
                let x;
                for(x in this.factura){
                    if(numFactura == this.factura[x].num && tipo == 'D'){
                        return this.moneyFormat(this.factura[x].credito,'');
                    }
                }

            },//Obtiene el saldo que tiene guardado el array de factura
            getSaldo(numFactura){
                let x;
                for(x in this.factura){
                    if(numFactura == this.factura[x].num){
                        return this.moneyFormat(this.factura[x].debito - this.factura[x].credito,'');
                    }
                }

            },
            total(){
                return _.sumBy(this.items, function(o) { return o.amount; });
            },
            pending(){
                return parseFloat(this.invoice.TotalComprobante) - this.total()
            },
            moneyFormat(n, s = '₡'){
         
                if(typeof n === "number"){

                        return s + n.format(2);
                }

                return s + n;
            },
            //Valida si va a imprimir un cxc de cliente o el historial del cliente
            print(){
                if(this.tipo == 'cxc'){
                    window.open(`/customers/${this.customerId}/cxc/print`,'name','width=800,height=400');
                }else{
                    window.open(`/customers/${this.customerId}/cxc/printP`,'name','width=800,height=400');
                }
               
            },

            fetch(page){
                axios.get(this.url(page))
                .then(this.refresh)
            },

            url(page){
                let url = `/customers/${this.customerId}/cxc`;

                if (! page) {
                    //let query = location.search.match(/page=(\d+)/);
                    page = 1;//query ? query[1] : 1;
                }
                
                url = `${url}?page=${page}`;



                return url;
            },

            refresh({data}){

             
                this.dataSet = data.data;
                this.items = data.data.data
                this.customer = data.customer
                this.items.sort(this.compare);
                this.credito(this.items);
            },
             destroy(item, index) {
                axios.delete(`/payments/${item.id}`);
                this.remove(index);
            },
           

        },
        created(){ 
            //Agregue tipo para saber si viene desde cxc o cxcPagadas

           window.events.$on('showCxcModal', (data,tipo) => {
               this.customerId = data;
               this.tipo = tipo;
               this.fetch()
           });


        }
      
    }
</script>

