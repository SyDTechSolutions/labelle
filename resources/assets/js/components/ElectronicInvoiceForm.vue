<template>
    <div class="invoice-form">
        <loading :show="loader"></loading> 
        <form-error v-if="errors.certificate" :errors="errors">
           
            <div class="callout callout-danger">
              <h4>Información importante!</h4>

              <p> {{ errors.certificate[0] }}</p>
            </div>
        </form-error>
        <form @submit.prevent="save()">
            <div class="row justify-content-between">
            
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white d-flex">
                                <div class="flex-grow-1">
                                    Factura de Compra
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="TipoDocumento">Tipo Documento</label>
                                        <select class="form-control custom-select" name="TipoDocumento" id="TipoDocumento" v-model="invoice.TipoDocumento" disabled>
                                            <option value="08">
                                                Factura de Compra
                                            </option>
                                        </select>
                                    </div>
                                
                                     <div class="form-group col-md-6">
                                        <label for="MedioPago">Medio Pago</label>
                                        <select class="form-control custom-select" name="MedioPago" id="MedioPago" v-model="invoice.MedioPago" :disabled="disableFields()" @change="calculateInvoice(invoice.lines)">
                                    
                                        <option v-for="(value, key, index) in medioPagos" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label for="CondicionVenta">Condición de venta</label>
                                        <select class="form-control custom-select" name="CondicionVenta" id="CondicionVenta" v-model="invoice.CondicionVenta" :disabled="disableFields()">
                                    
                                        <option v-for="(value, key, index) in condicionVentas" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="PlazoCredito">Plazo de credito</label>
                                        <!-- <input type="text" class="form-control" name="PlazoCredito" v-model="invoice.PlazoCredito" :disabled="invoice.CondicionVenta != '02' || disableFields()" > -->
                                         <flat-pickr
                                                v-model="invoice.PlazoCredito"                                             
                                                class="form-control" 
                                                placeholder="Selecione una fecha"               
                                                name="PlazoCredito"
                                                :disabled="invoice.CondicionVenta != '02' || disableFields()"
                                                >
                                        </flat-pickr>
                                        <form-error v-if="errors.PlazoCredito" :errors="errors" style="float:right;">
                                            {{ errors.PlazoCredito[0] }}
                                        </form-error>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="initialPayment">Abono inicial</label>
                                        <input type="text" class="form-control" name="initialPayment" v-model="invoice.initialPayment" :disabled="invoice.CondicionVenta != '02' || disableFields()" >
                                    </div>
                                </div>
                                <div class="form-row">
                                   
                                
                                    <div class="form-group col-md-12">
                                        <label for="observations">Observaciones</label>
                                         <textarea name="observations" class="form-control" v-model="invoice.observations" cols="30" rows="1" :disabled="disableFields()"></textarea>
                                       
                                            
                                        <form-error v-if="errors.observations" :errors="errors" style="float:right;">
                                            {{ errors.observations[0] }}
                                        </form-error>
                                    </div>
                                    
                                
                                </div>
                                
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Emisor
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                     <div class="form-group col-md-4">
                                        <label for="tipo_identificacion_emisor">Tipo Identificacion</label>
                                        <select class="form-control custom-select" name="tipo_identificacion_emisor" id="tipo_identificacion_emisor" v-model="invoice.tipo_identificacion_emisor" @change="changeTipoIdentificacion()" >
                                        
                                        <option value=""></option>
                                        <option v-for="(value, key, index) in tipoIdentificaciones" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                        <form-error v-if="errors.tipo_identificacion_emisor" :errors="errors" style="float:right;">
                                            {{ errors.tipo_identificacion_emisor[0] }}
                                        </form-error>
                                    </div>
                                
                                    <div class="form-group col-md-4">
                                        <label for="identificacion_emisor">Identificacion</label>
                                       
                                        <input type="text" class="form-control" id="identificacion_emisor" placeholder="" v-model="invoice.identificacion_emisor" @keyup="listenCliente($event)" >
                                            
                                        <form-error v-if="errors.identificacion_emisor" :errors="errors" style="float:right;">
                                            {{ errors.identificacion_emisor[0] }}
                                        </form-error>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="cliente">Nombre Proveedor</label>
                                        <div class="input-group">
                                        
                                            <div class="input-group-prepend" v-if="!disableFields()">
                                                <button class="btn btn-outline-secondary" 
                                                type="button"
                                                data-toggle="modal"
                                                data-target="#providersModal"
                                                @click="showModalProviders()">Buscar</button>
                                            </div>
                                            <input type="text" class="form-control" id="cliente" placeholder="" v-model="invoice.emisor" @keyup="listenCliente($event)" @keydown.prevent.enter="searchProvider()" required :disabled="disableFields()">
                                            
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                    <div class="form-group col-md-12">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" v-model="invoice.email" >
                                    </div>
                                   
                                </div>
                            </div>
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
                                    <input type="text" class="form-control" name="code" id="codeProduct" placeholder="Codigo" v-model="code" @keydown.prevent.enter="searchProduct()" :disabled="disableFields()">
                                    <div hidden><button class="btn btn-outline-secondary" 
                                        type="button" @click="addCode()" id="btnCode">Agregar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                            <th scope="col"></th>
                                             <th scope="col" title="Actualizar impuesto">Imp.</th>
                                            <th scope="col" title="Exonerar Linea">Exo.</th>
                                            <th scope="col">#</th>
                                            <th scope="col">Codigo</th>
                                            <th scope="col" style="width:250px;">Detalle</th>
                                            <th scope="col" style="width:90px;">Exis</th>
                                            <th scope="col" style="width:90px;">Cantidad</th>
                                            <th scope="col">Unidad</th>
                                            <th scope="col">Precio Uni.</th>
                                            <th scope="col" style="width:90px;">% Desc</th>
                                            <th scope="col">Subtotal</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="(line, index) in invoice.lines">
                                            <tr :key="line.id">
                                               
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
                                                    <td class="py-2 px-2">
                                                        <button type="button" class="btn btn-success btn-sm" title="Impuestos" 
                                                        data-toggle="modal"
                                                        data-target="#taxesModal"
                                                        @click="showModalTaxes(line, index)" v-if="!disableFields()" >
                                                            Imp
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox"
                                                            name="exo"
                                                            v-model="line.exo"
                                                            title="Exonerar Linea" @change="showExo(line, index)" :data-target="'.multi-collapse-line'+ index" data-toggle="collapse">                                                    
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
                                                    <td>{{ line.UnidadMedida }}</td>
                                                    <td>{{ moneyFormat(line.PrecioUnitario) }}</td>
                                                    <td>
                                                        <input
                                                            class="form-control form-control-sm"
                                                            type="text" 
                                                            v-model="line.PorcentajeDescuento"
                                                            @blur="refreshLine(line, index)"
                                                            @keydown.enter.prevent="refreshLine(line, index)"
                                                            v-if="!disableFields()"
                                                            >
                                                        <span v-else> {{ line.PorcentajeDescuento }}</span>
                                                    </td>
                                                
                                                    <td>{{ moneyFormat(line.SubTotal) }}</td>
                                                    <!-- No aplica para este negocio -->    
                                            </tr>

                                        </template>
                                            
                                            <tr>
                                                <td :colspan="11" class="text-right">SubTotal:</td>
                                                <td> {{ moneyFormat(invoice.TotalVentaNeta) }} </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="11" class="text-right">Descuentos:</td>
                                                <td> {{ moneyFormat(invoice.TotalDescuentos) }} </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="11" class="text-right">Impuestos:</td>
                                                <td> {{ moneyFormat(invoice.TotalImpuesto) }} </td>
                                            </tr>
                                            <tr v-show="invoice.MedioPago == '02'">
                                                <td :colspan="11" class="text-right">IVA Devuelto:</td>
                                                <td> -{{ moneyFormat(invoice.TotalIVADevuelto) }} </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="11" class="text-right">Total:</td>
                                                <td> {{ moneyFormat(invoice.TotalComprobante) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                               
                                
                            </div>
                        </div> <!--card productos-->

                         <div class="form-group">
                            <button type="submit" class="btn btn-success" v-if="!disableFields()">Guardar</button>
                            <button type="button" class="btn btn-dark" @click="requestEmail(invoice)" v-if="invoice.id">Enviar por correo</button>
                            <a :href="'/electronicinvoice/'+ invoice.id +'/print'" class="btn btn-dark" v-if="invoice.id" role="button">Imprimir</a>
                            <a :href="'/electronicinvoice/'+ invoice.id +'/ticket'" class="btn btn-dark" v-if="invoice.id" role="button">Ticket</a>
                        
                            <a href="/electronicinvoice" class="btn btn-light" role="button">Regresar</a>
                        </div>
                    </div>  <!--col-->
            </div>

        </form>

        <providers-modal @assigned="addProvider" :tipo-identificaciones="tipoIdentificaciones"></providers-modal>
        <products-modal @assigned="addProduct"></products-modal>
        <modal-resumen-factura :medio-pagos="medioPagos" @recalculateInvoice="calculateInvoice(invoice.lines)" @saveResumenFactura="persist()"></modal-resumen-factura>
        <taxes-modal @assigned="addTax" @remove="removeTax"></taxes-modal>

    </div>
    
</template>
<script>

import ProvidersModal from "./ProvidersModal.vue";
import ProductsModal from "./ProductsModal.vue";
import ModalResumenFactura from "./ModalResumenFactura.vue";
import TaxesModal from "./TaxesModal.vue";
import FormError from "./FormError.vue";
import Loading from "./Loading.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
export default {
   props:['currentInvoice','tipoDocumentos','tipoDocumentosNotas','medioPagos','condicionVentas','currentTipoDocumento','tipoIdentificaciones', 'users','currentUser', 'setting'],
   data () {
       return {
           invoice:{
               TipoDocumento:'08',
               provider_id:0,
               emisor:'',
               email:'',
               tipo_identificacion_emisor: '',
               identificacion_emisor: '',
               MedioPago:'01',
               CondicionVenta:'01',
               PlazoCredito:'',
               TotalServGravados: 0,
               TotalServExentos: 0,
               TotalServExonerado:0,
               TotalMercanciasGravadas: 0,
               TotalMercanciasExentas: 0,
               TotalMercExonerada:0,
               TotalGravado: 0,
               TotalExento: 0,
               TotalExonerado: 0,
               TotalVenta: 0,
               TotalDescuentos: 0,
               TotalVentaNeta: 0,
               TotalImpuesto: 0,
               TotalIVADevuelto:0,
               TotalComprobante:0,
               lines:[],
               initialPayment:'',
               status:1,
               observations:'',
               pay_with:0,
               change:0,
               created_by: this.currentUser ? this.currentUser.id : 0
           },
           code:'',
           customerDiscount:0,
           cambio:false,
           errors:[],
           loader: false,
       }
   },
   components:{
       ProvidersModal,
       ProductsModal,
       ModalResumenFactura,
       TaxesModal,
       FormError,
       Loading,
       flatPickr
   },
   computed:{
       isAdmin(){
           return window.App.isAdmin;
       }
   },
   methods:{
       addCode(){
           this.code = $('#codeProduct').val();  
           this.searchProduct();
       },
       changeTipoIdentificacion(){
            
           if(this.invoice.tipo_identificacion_cliente == '00' && this.invoice.TipoDocumento != '04'){

                Swal({
                    title: 'Facturacion a extranjero',
                    html: 'Para facturar a un extranjero solo se puede con Tiquete Electrónico. Deseas realizar el cambio?',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Si'
                }).then( (result) => {
                    
                    if (result.value) {
                        this.invoice.TipoDocumento = '04'; // si es extranjero pasamos la factura a tiquete
                    }

                });

                
               
           }
        },
       disableFields(){
           
           return (this.invoice.id)
       },
       tipoDocumentoName(tipoDocumento){
           return _.get(this.tipoDocumentosNotas, tipoDocumento);
       },
       tipoCodigoReferenciaName(codigo){
           return _.get(this.codigoReferencias, codigo);
       },
       numberFormat(n){
            if(n){

                return parseFloat(n).format(0);
            }
            return 0;
         
       },
       moneyFormat(n){
         
           if(typeof n === "number"){

                return '₡' + n.format(2);
           }

           return '₡' + n;
       },
       listenCliente(e){
          
           if(!e.target.value){
               this.invoice.provider_id = 0;
           }
       },
        showModalTaxes(line, index){
                let data = {
                    line:line,
                    index:index
                };
               window.events.$emit('showTaxesModal', data)
   
       },
       removeTax(data){
            let line = data.dataLine.line 
            let index = data.dataLine.index;
            let tax = data.tax;
            

            let indexTax = _.findIndex(line.taxes, { 'code': tax.code });

            line.taxes.splice(indexTax, 1);
            line.overrideImp = true;

           this.refreshLine(line, index);
              
           
       },
       addTax(data){
            let line = data.dataLine.line 
            let index = data.dataLine.index;
            let tax = data.tax;
            

            line.taxes.push(tax);
            line.overrideImp = true;

           this.refreshLine(line, index);
              
           
       },
       showModalProviders(){
              
               window.events.$emit('showProvidersModal')
   
       },
        showModalProducts(){
         
                 window.events.$emit('showProductsModal')
   
       },
       searchProvider(){
          
            axios.get(`/providers?q=${this.invoice.emisor}`)
                .then(({data}) => {
                    
                    this.invoice.provider_id = 0;
                    this.invoice.email = '';

                    if(data.data){
                        
                        if(data.data.length == 1){
                            this.addProvider(data.data[0]);
                             flash('Proveedor Agregado');
                             
                        }else{
                            $('#providersModal').modal();
                            window.events.$emit('showProvidersModal', { searchTerm: this.invoice.emisor})
                        }
                       
                    }else{
                        flash('Proveedor No encontrado', 'danger');
                    }
                })
       },
        addProvider(proveedor){ 
           this.invoice.provider_id = proveedor.id
           this.invoice.emisor = proveedor.name
           this.invoice.email = proveedor.email
           this.invoice.identificacion_emisor = proveedor.identificacion
           let discount = parseFloat(proveedor.PorcentajeDescuento)
           this.customerDiscount = discount      
       },
       addProduct(product){
           
           this.createInvoiceLine(product)
          
       },
       removeLine(product, index){
            this.invoice.lines.splice(index, 1);
            this.calculateInvoice(this.invoice.lines)
       },

       createInvoiceLine(product){
             let lineIndexFound = _.findIndex( this.invoice.lines, function(o) {
                    return o.Codigo === product.code;
             });
             let lineFound = _.find( this.invoice.lines, function(o) {
                    return o.Codigo === product.code;
             });

             if(lineFound && lineIndexFound !== -1)
             {
                lineFound.Cantidad++
   
                this.updateInvoiceLine(this.calculateInvoiceLine(lineFound, lineIndexFound), lineIndexFound);
                 
             }else{


                  let nuevo = {
                        CodigoProductoHacienda: product.CodigoProductoHacienda,
                        Codigo: product.code,
                        Detalle: product.name,
                        existencias: product.quantity,
                        Cantidad: 1,
                        UnidadMedida: product.measure,
                        PrecioUnitario: product.price,
                        MontoTotal: 0,
                        PorcentajeDescuento: this.customerDiscount,
                        MontoDescuento: 0,
                        NaturalezaDescuento:'',
                        SubTotal: 0,
                        MontoTotalLinea: 0,
                        totalTaxes:0,
                        taxes: product.taxes,
                        type: product.type,
                        existencias: parseFloat(product.quantity), // para verificar
                        product:product,
                        is_servicio_medico: product.is_servicio_medico,
                        overrideImp:false
                       
                    }
                  
                let line = this.calculateInvoiceLine(nuevo, 0);

                 this.invoice.lines.push(line);
             }

            this.calculateInvoice(this.invoice.lines)
            this.code = '';
       },

       refreshLine(line, index){
          this.updateInvoiceLine(this.calculateInvoiceLine(line, index), index);
       },

       updateInvoiceLine(line, index){
          
           this.invoice.lines.splice(index, 1, line);
           this.calculateInvoice(this.invoice.lines)
       },
       calculateExoneration(line, lineTax, index){
          
           
            let taxes = [];
            let PorcentajeExo = 0;
            let ImpuestoNeto = 0;
            let MontoExoneracion = 0;
            
            let lineasTaxes = (line.product && line.product.taxes && line.product.taxes.length && !line.overrideImp) ? line.product.taxes : line.taxes;

           lineasTaxes.forEach(tax => {
                
                let tarifa = parseFloat(tax.TarifaOriginal ? tax.TarifaOriginal : tax.tarifa);
                let subTotal = (tax.code == '07') ? line.BaseImponible : line.SubTotal; //IVA especial se utliza base imponible

                let MontoImpuesto = redondeo((parseFloat(tarifa)/100) * subTotal, 5); // se roundM por problemas de decimales de hacienda
            
                ImpuestoNeto = MontoImpuesto;

                if(line.exo /* && (!this.invoice.id || this.isCreatingNota) */ ){
                    
                    PorcentajeExo = parseFloat(lineTax.PorcentajeExoneracion ? lineTax.PorcentajeExoneracion : 0);

                    if(PorcentajeExo > tarifa){
                        PorcentajeExo = tarifa;
                        lineTax.PorcentajeExoneracion = tarifa;
                    }
                   
                    MontoExoneracion = redondeo((PorcentajeExo / 100) * subTotal, 5); // se cambió MontoImpuesto por subTotaldel cambio del 1 de julio 2020
                

                    ImpuestoNeto =  MontoImpuesto - MontoExoneracion;

                    
                }

                lineTax.MontoExoneracion = MontoExoneracion;
                lineTax.ImpuestoNeto = ImpuestoNeto;
                lineTax.tarifa = tarifa;
                
                taxes.push({
                    code: tax.code,
                    CodigoTarifa: tax.CodigoTarifa,
                    name: tax.name,
                    tarifa: tarifa,
                    amount: MontoImpuesto,
                    TipoDocumento: lineTax.TipoDocumento,
                    NumeroDocumento: lineTax.NumeroDocumento,
                    NombreInstitucion: lineTax.NombreInstitucion,
                    FechaEmision: lineTax.FechaEmision,
                    PorcentajeExoneracion: lineTax.PorcentajeExoneracion ? lineTax.PorcentajeExoneracion : 0,
                    MontoExoneracion: lineTax.MontoExoneracion ? lineTax.MontoExoneracion : 0,
                    TarifaOriginal: tarifa,
                    ImpuestoOriginal: MontoImpuesto,
                    ImpuestoNeto: lineTax.ImpuestoNeto
                    
                })

            });


            line.taxes = taxes;

            return line;       

       },
       calculateInvoiceLine(line, index){
            
           
            line.Cantidad = parseFloat(line.Cantidad);
            line.PrecioUnitario = parseFloat(line.PrecioUnitario);
            line.PorcentajeDescuento = parseFloat(line.PorcentajeDescuento ? line.PorcentajeDescuento : 0);
            line.existencias = parseFloat(line.existencias);

            let totalSolicitado = line.Cantidad;
            let totalActual = line.existencias;
            
            if(totalSolicitado > totalActual && this.setting.verificar_existencias){
                 Swal({
                    title: 'No hay suficientes existencias de este producto',
                    html: 'Verifica las existencias',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Ok'
                }).then( (result) => {
    

                });
                
                line.Cantidad = totalActual;

                //return line;
            }

            let taxes = [];
            let MontoTotal = line.PrecioUnitario * line.Cantidad;
            let MontoDescuento = redondeo((line.PorcentajeDescuento / 100) * MontoTotal, 5);
            let SubTotal = MontoTotal - MontoDescuento;
            let BaseImponible = SubTotal;//line.BaseImponible ? parseFloat(line.BaseImponible) : SubTotal;
            let totalTaxes = 0;
            let ImpuestoNeto = 0;

            line.MontoTotal = MontoTotal;
            line.MontoDescuento = MontoDescuento;
            //line.NaturalezaDescuento ='';
            line.SubTotal = SubTotal;
            line.BaseImponible = BaseImponible;
              

              
            line.taxes.forEach(tax => {
                
                
                   this.calculateExoneration(line, tax, index)
                        let subTotalbase = (tax.code == '07') ? line.BaseImponible : line.SubTotal; //IVA especial se utliza base imponible
                        let MontoImpuesto = redondeo((parseFloat(tax.tarifa)/100) * subTotalbase, 5);
                        

                        taxes.push({
                            code: tax.code,
                            CodigoTarifa: tax.CodigoTarifa,
                            name: tax.name,
                            tarifa: tax.tarifa,
                            amount: MontoImpuesto,
                            TipoDocumento: tax.TipoDocumento,
                            NumeroDocumento: tax.NumeroDocumento,
                            NombreInstitucion: tax.NombreInstitucion,
                            FechaEmision: tax.FechaEmision,
                            PorcentajeExoneracion: tax.PorcentajeExoneracion ? tax.PorcentajeExoneracion : 0,
                            MontoExoneracion: tax.MontoExoneracion ? tax.MontoExoneracion : 0,
                            TarifaOriginal: tax.TarifaOriginal ? tax.TarifaOriginal : tax.tarifa,
                            ImpuestoOriginal: tax.ImpuestoOriginal ? tax.ImpuestoOriginal : 0,
                            ImpuestoNeto: tax.ImpuestoNeto ? tax.ImpuestoNeto : 0
                            
                        })

                    totalTaxes += tax.ImpuestoNeto;

                     
            });

        
            line.totalTaxes = totalTaxes;
            line.MontoTotalLinea = line.SubTotal + totalTaxes;
            line.taxes = taxes;

            return line;


       },
       calculateInvoice(lines){
            
            let TotalMercanciasGravadas = 0;
            let TotalMercanciasExentas = 0;
            let TotalServGravados = 0;
            let TotalServExentos = 0;
            let TotalGravado = 0;
            let TotalExento = 0;
            let TotalVenta = 0; 
            let TotalDescuentos = 0;
            let TotalVentaNeta = 0;
            let TotalImpuesto = 0;
            let TotalComprobante = 0;
            let TotalServExonerado = 0;
            let TotalMercExonerada = 0;
            let TotalExonerado = 0;
            let TotalIVADevuelto = 0;
            let PagoCon = 0;
            let Vuelto = 0;

           lines.forEach(line => {
               
               if(line.type == 'P'){

                    if(line.taxes.length){
                        
                        line.taxes.forEach(tax => {
                            if(line.exo){
                                
                                 let porcenExoProporcion = 100-((parseFloat(tax.tarifa) - parseFloat(tax.PorcentajeExoneracion)) * (100 / parseFloat(tax.tarifa)));
                               
                                TotalMercanciasGravadas += (1 - porcenExoProporcion/100) * line.MontoTotal;
                                  
                                TotalMercExonerada += (porcenExoProporcion/100) * line.MontoTotal

                                

                            }else{
                                TotalMercanciasGravadas += parseFloat(line.MontoTotal);
                                TotalMercExonerada += 0;
                            }
                        });
                        
                        
                    }else{
                        TotalMercanciasExentas += parseFloat(line.MontoTotal);
                        TotalMercExonerada += 0;
                    }

               }else{ // type S : Servicio
                   if(line.taxes.length){
                        
                        line.taxes.forEach(tax => {
                                if(line.exo){
                                  
                                    let porcenExoProporcion = 100-((parseFloat(tax.tarifa) - parseFloat(tax.PorcentajeExoneracion)) * (100 / parseFloat(tax.tarifa)));
                                       
                                    TotalServGravados += (1-porcenExoProporcion/100) * line.MontoTotal;
                                    
                                    TotalServExonerado += (porcenExoProporcion/100) * line.MontoTotal;
                                   
                                 }else{
                                    TotalServGravados += parseFloat(line.MontoTotal);
                                    TotalServExonerado += 0;
                                }

                                
                                //IVA devuelto para servicios medicos pagados con tarjeta
                                if(line.is_servicio_medico && this.invoice.MedioPago == '02'){
                                        TotalIVADevuelto += tax.ImpuestoNeto
                                    }
                            });
                       
                       
                        
                        
                    }else{
                        TotalServExentos += parseFloat(line.MontoTotal);
                        TotalServExonerado += 0;
                    }

               }

               TotalDescuentos += parseFloat(line.MontoDescuento);
               TotalImpuesto += parseFloat(line.totalTaxes);
             

            });

            TotalGravado = TotalMercanciasGravadas + TotalServGravados;
            TotalExento = TotalMercanciasExentas + TotalServExentos;
            TotalExonerado = TotalMercExonerada + TotalServExonerado;

            TotalVenta = TotalGravado + TotalExento + TotalExonerado;
            TotalVentaNeta = TotalVenta - TotalDescuentos;
            TotalComprobante = TotalVentaNeta + TotalImpuesto - TotalIVADevuelto;

            this.invoice.TotalMercanciasGravadas = TotalMercanciasGravadas;
            this.invoice.TotalMercanciasExentas = TotalMercanciasExentas;
            this.invoice.TotalMercExonerada = TotalMercExonerada;
            
            this.invoice.TotalServGravados = TotalServGravados;
            this.invoice.TotalServExentos = TotalServExentos;
            this.invoice.TotalServExonerado = TotalServExonerado;
            this.invoice.TotalGravado = TotalGravado;
            this.invoice.TotalExento = TotalExento;
            this.invoice.TotalExonerado = TotalExonerado;
            this.invoice.TotalVenta = TotalVenta; 
            this.invoice.TotalDescuentos = TotalDescuentos;
            this.invoice.TotalVentaNeta = TotalVentaNeta;
            this.invoice.TotalImpuesto = TotalImpuesto;
            this.invoice.TotalIVADevuelto = TotalIVADevuelto;
            this.invoice.TotalComprobante = TotalComprobante;


            // para vuelto
            PagoCon = parseFloat(this.invoice.pay_with);
            Vuelto =  PagoCon - this.invoice.TotalComprobante;
            this.invoice.change = Vuelto < 0 ? 0 : Vuelto;
  

            
        
           
            return this.invoice;


       },
       save(){
            this.errors = [];
             if(this.invoice.tipo_identificacion_cliente == '00' && this.invoice.TipoDocumento != '04'){
                Swal({
                    title: 'Facturación Extranjero',
                    html: 'Para facturar a un extranjero tiene que ser un Tiquete Electrónico',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Ok'
                }).then( (result) => {
    

                });

                return
           }
            if(!this.invoice.lines.length){
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
           let errorM = {};
           this.invoice.lines.forEach(line => {
               if(line.exo){
                    line.taxes.forEach(tax => {
                        if(!tax.TipoDocumento)
                        {
                            errorM.TipoDocumento = ['Tipo de documento requerido']

                        }
                        if(!tax.NumeroDocumento)
                        {
                            errorM.NumeroDocumento = ['Numero de documento requerido']

                        }
                        if(tax.NumeroDocumento && tax.NumeroDocumento.length > 17)
                        {
                            errorM.NumeroDocumento = ['Numero de documento tiene que ser de 17 caracteres']

                        }
                        if(!tax.NombreInstitucion)
                        {
                            errorM.NombreInstitucion = ['Nombre de la institución requerido']

                        }
                        if(!tax.FechaEmision)
                        {
                            errorM.FechaEmision = ['Fecha Emisión requerido']

                        }
                        if(!tax.PorcentajeExoneracion)
                        {
                            errorM.PorcentajeExoneracion = ['Porcentaje Exoneración requerido']

                        }
                        
                    });
                   
               }
                this.errors = errorM;
           });
           if(!_.isEmpty(this.errors)){

               Swal({
                    title: 'Información de exoneración requerido o erronea',
                    html: 'En algunas de las lineas que tienen exoneración falta o hay información erronea. Revisa!',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Ok'
                }).then( (result) => {
    

                });

                return;
            }
          
           if((this.invoice.TipoDocumento == '01' || this.invoice.TipoDocumento == '04') && this.invoice.MedioPago == '01'){

               $('#modalResumenFactura').modal();
                window.events.$emit('showResumenFacturaModal', this.invoice)



           }else{
               this.persist();
           }

           
       },
       persist(){
            if(this.loader) {
               return;
           }

           this.loader = true;
           axios.post(`/electronicinvoice`, this.invoice)
                .then(({data}) => {
                    this.loader = false;
                    this.clearForm();
                    flash('Factura Guardada Correctamente.');
                    this.$emit('created', data);
                        
                    this.actions(data)

                })
                .catch(error => {
                    this.loader = false;
                    if(error.response.status == 500 || error.response.status == 504)
                    {
                         this.clearForm();
                       
                        flash('La Factura fue creada, pero ocurrió un error. ' + error.response.data.message, 'danger');

                    }else{
                        flash('Error al guardar la factura!!', 'danger');
                    }

                    this.errors = error.response.data.errors ? error.response.data.errors : [];
                });

       },
       requestEmail(invoice){
           
           Swal({
                title: 'Correo',
                input: 'text',
                inputPlaceholder: '',
                showCancelButton: true,
                confirmButtonText: 'Enviar',
                showLoaderOnConfirm: true,
                inputValue: invoice.email ? invoice.email : '',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value === '') {
                            resolve('Necesitas agregar al menos un correo')
                        } else {
                            resolve()
                        }
                    })
                },
                preConfirm: (email) => {
                    console.log('entro para enviar la factura')
                    return axios.post('/electronicinvoice/'+ invoice.id + '/pdf',{ to: email })
                        .then(resp => {})
                        .catch(error =>{
                           
                            Swal.showValidationError(
                                `Request failed: ${error}`
                                )
                                
                            flash('Error al enviar la factura por correo!!', 'danger');
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
                
            })
            .then( (result) => {
            
            
                if (result.value) {
                   
                     Swal({
                        title: `Factura Enviada Correctamente`,
                       
                        }).then( (result) => {

                            if(invoice.TipoDocumento != '01' && invoice.TipoDocumento != '04'){
                                window.location = '/electronicinvoice'
                            }

                        });
                
                }
                

            });
       },
       actions(invoice){
           Swal({
                title: 'Factura Guardada',
                html: '¿Deseas Imprimir o enviar por correo?',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Correo',
                confirmButtonText: 'Imprimir',
                input: 'select',
                inputOptions: {
                    '1': 'Impresora Ticket',
                    '2': 'Impresora Normal',
                    
                },
                inputValue: '2',
                inputPlaceholder: 'Impresora',
                inputValidator: (value) => {
                            return new Promise((resolve) => {
                            if (value === '') {
                               resolve('Necesitas seleccionar un tipo de impresora')
                            } else {
                                resolve()
                            }
                            })
                        }
            }).then( (result) => {
                
                 if (result.value == 1) {
                    window.location = '/invoices/' + invoice.id + '/ticket'

                }else if(result.value == 2){
                    window.location = '/invoices/' + invoice.id + '/print'
                }else if (result.dismiss === Swal.DismissReason.cancel) {
                    
                        this.requestEmail(invoice)
                    
                }else{
                    window.location = '/electronicinvoice'
                }


                

            });
       },
       clearForm(){

           this.invoice = {
               TipoDocumento:'01',
               customer_id:0,
               cliente:'',
               email:'',
               tipo_identificacion_cliente: '',
               identificacion_cliente: '',
               MedioPago:'01',
               CondicionVenta:'01',
               PlazoCredito:'',
               TotalServGravados: 0,
               TotalServExentos: 0,
               TotalServExonerado:0,
               TotalMercanciasGravadas: 0,
               TotalMercanciasExentas: 0,
               TotalMercExonerada:0,
               TotalGravado: 0,
               TotalExento: 0,
               TotalExonerado: 0,
               TotalVenta: 0,
               TotalDescuentos: 0,
               TotalVentaNeta: 0,
               TotalImpuesto: 0,
               TotalIVADevuelto:0,
               TotalComprobante:0,
               lines:[],
               referencias:[],
               initialPayment:'',
               status:1,
               observations:'',
               pay_with:0,
               change:0,
               created_by: this.currentUser ? this.currentUser.id : 0
           };

           this.code = '';
           this.customerDiscount = 0;

            

       },
     
       
   },
   created(){
       if(this.currentInvoice){
           this.invoice = this.currentInvoice;

           this.invoice.lines.forEach((line, index) => {
               this.refreshLine(line, index);
           });
           this.calculateInvoice(this.invoice.lines)
           
       }
   }

}
</script>
