<template>
  <div class="modal fade" id="modalResumenFactura" role="dialog" aria-labelledby="modalResumenFactura">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
             
            <div class="modal-header">
            
                <h4 class="modal-title" id="modalRespHaciendaLabel">Resumen Factura. Total: {{ moneyFormat(invoice.TotalComprobante) }}</h4>
            
            </div>
            <form v-on:submit.prevent="save">
                <div class="modal-body">
                  <loading :show="loader"></loading>
                  
                <div class="form-row">
                    
                    <div class="form-group col-md-12">
                        <label for="MedioPago">Medio Pago</label>
                        <select class="form-control custom-select" v-model="invoice.MedioPago" :disabled="disableFields()" @change="updateMedioPago()" >
                    
                        <option v-for="(value, key, index) in medioPagos" :value="key" :key="index">
                            {{ value }}
                        </option>
                        
                        </select>
                    </div>
                    
                </div>
                <div class="form-row">
                    
                    <div class="form-group col-md-9" v-show="invoice.MedioPago == '01'">
                        <label for="pay_with">Pago Con</label>
                        <input type="number" id="payWith" class="form-control" placeholder="" v-model="pago" @keyup="calcularVuelto()" autofocus>
                    </div>
    
                    <div class="form-group col-md-3" v-show="invoice.MedioPago == '01'">
                        <label for="cambio">Moneda</label>
                        <select class="form-control" name="cambio" id="cambio" v-model="cambio" @change="calcularVuelto()">
                    
                            <option value="0">₡ (Colones)</option>
                            <option value="1">$ (Dólar)</option>
                            
    
                        </select> 
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <h3 v-if="cambio == '1'" style="font-size: 14px;">Conversion dollar: {{ dolarValue * pago }}</h3>
                        <h4>Total: {{ moneyFormat(invoice.TotalComprobante) }}</h4>  
                        <h3 style="color:red;z">Vuelto: {{ moneyFormat(vuelto) }}</h3>   
                        <h6 v-show="invoice.MedioPago == '02'">IVA Devuelto:  {{ moneyFormat(invoice.TotalIVADevuelto) }} </h6>
                    </div>
                </div>
                     
                </div>
                 <div class="modal-footer" >
                 
                    <button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                  
                 
                </div>
            </form>
          </div>
        </div>
    </div>
</template>
<script>

import Loading from './Loading.vue';

export default {
  props:['medioPagos','dolarValue','currency'],
  data () {
      return {
          invoice: {},
          loader:false,
          vuelto:0,
          cambio:0,
          pago:'',
          currencyCode: this.currency
      }
  },
  components:{
      Loading
  },
  methods:{
    calcularVuelto(){
        console.log(this.cambio)
        if(this.cambio == '0'){
            this.vuelto = parseFloat(this.pago - this.invoice.TotalComprobante).toFixed(2);
            this.invoice.pay_with = this.pago
            this.updatePagoCon()
        }
        if(this.cambio == '1'){
            let colones = this.pago * this.dolarValue
            console.log(colones)
            this.vuelto = parseFloat(colones - this.invoice.TotalComprobante).toFixed(2)
            this.invoice.pay_with = colones
            this.updatePagoCon()
        }
        if(this.cambio == 2){
            let colones = this.pago * this.moneda[1].monto
            this.vuelto = parseFloat(colones - this.invoice.TotalComprobante).toFixed(2)
            this.invoice.pay_with = colones
            this.updatePagoCon()
        }
    },
    moneyFormat(n){
            let symbol = this.currencyCode == "CRC" ? '₡' : '$';
        if(typeof n === "number"){

                return symbol + n.format(2);
        }

        return symbol + n;
    },
    disableFields(){
        
        return (this.invoice.id)
    },
    updatePagoCon(){
            this.$emit('recalculateInvoice');
    },
    updateMedioPago(){

        if(this.invoice.MedioPago == '02'){
            this.invoice.pay_with = 0;
            this.invoice.change = 0;
        }
        
        this.$emit('recalculateInvoice');
    },
    save(){
        this.$emit('saveResumenFactura');
        $(this.$el).find('.btn-close-modal').click();
    },
     
  },
  created(){
    this.cambio = this.currencyCode == "CRC" ? 0 : 1;
    window.events.$on('showResumenFacturaModal', (data) => {
        this.invoice = data
    });
  },
  mounted(){
  }
}
</script>
