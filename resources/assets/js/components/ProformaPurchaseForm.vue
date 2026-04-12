<template>
    <div class="invoice-form">
        <loading :show="loader"></loading> 
        <form @submit.prevent="save()">
            <div class="row justify-content-between">
            
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Proforma de Compra</div>

                            <div class="card-body">
                                <div class="form-row">
                                   
                                    <div class="form-group col-md-2">
                                        <label for="TipoDocumento">Tipo Documento</label>
                                        <select class="form-control custom-select" name="TipoDocumento" id="TipoDocumento" v-model="proforma.TipoDocumento">
                                    
                                        <option v-for="(value, key, index) in tipoDocumentos" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                     <div class="form-group col-md-2">
                                        <label for="fecha_factura">Fecha Factura</label>
                                        <!-- <input type="text" class="form-control" name="fecha_factura" v-model="proforma.fecha_factura" :disabled="disableFields()"> -->
                                        <flat-pickr
                                                v-model="proforma.fecha_factura"                                             
                                                class="form-control" 
                                                placeholder="Select date"               
                                                name="date">
                                        </flat-pickr>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="factura_proveedor">Factura Proveedor</label>
                                        <input type="text" class="form-control" name="factura_proveedor" v-model="proforma.factura_proveedor" :disabled="disableFields()" @blur="checkFactura()">

                                         <form-error v-if="errors.factura_proveedor" :errors="errors">
                                            {{ errors.factura_proveedor[0] }}
                                        </form-error>
                                        
                                    </div>
                                
                                    <div class="form-group col-md-3">
                                        <label for="cliente">Nombre Proveedor</label>
                                        <div class="input-group">
                                        
                                            <div class="input-group-prepend" v-if="!disableFields()">
                                                <button class="btn btn-outline-secondary" 
                                                type="button"
                                                data-toggle="modal"
                                                data-target="#providersModal"
                                                @click="showModalProviders()">Buscar</button>
                                            </div>
                                            <input type="text" class="form-control" id="cliente" placeholder="" v-model="proforma.cliente" @keyup="listenCliente($event)" @keydown.prevent.enter="searchProvider()" required :disabled="disableFields()">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" v-model="proforma.email" :disabled="disableFields()">
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                    <div class="form-group col-md-3">
                                        <label for="MedioPago">Medio Pago</label>
                                        <select class="form-control custom-select" name="MedioPago" id="MedioPago" v-model="proforma.MedioPago" :disabled="disableFields()">
                                    
                                        <option v-for="(value, key, index) in medioPagos" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="CondicionVenta">Condición de venta</label>
                                        <select class="form-control custom-select" name="CondicionVenta" id="CondicionVenta" v-model="proforma.CondicionVenta" :disabled="disableFields()">
                                    
                                        <option v-for="(value, key, index) in condicionVentas" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="PlazoCredito">Plazo de credito</label>
                                        <!-- <input type="text" class="form-control" name="PlazoCredito" v-model="proforma.PlazoCredito" :disabled="proforma.CondicionVenta != '02' || disableFields()" > -->
                                        <flat-pickr
                                                v-model="proforma.PlazoCredito"                                             
                                                class="form-control" 
                                                placeholder="Selecione una fecha"               
                                                name="PlazoCredito">
                                        </flat-pickr>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="initialPayment">Abono inicial</label>
                                        <input type="text" class="form-control" name="initialPayment" v-model="proforma.initialPayment" :disabled="proforma.CondicionVenta != '02' || disableFields()" >
                                    </div>
                                </div>
                                <div class="form-row">
                                   
                                
                                    <div class="form-group col-md-12">
                                        <label for="observations">Observaciones</label>
                                         <textarea name="observations" class="form-control" v-model="proforma.observations" cols="30" rows="1"></textarea>
                                       
                                            
                                        <form-error v-if="errors.observations" :errors="errors" style="float:right;">
                                            {{ errors.observations[0] }}
                                        </form-error>
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
                                                <th scope="col" style="width:110px;">Precio Uni.</th>
                                                
                                                <th scope="col" style="width:80px;">% Util.</th>
                                                <th scope="col" style="width:80px;">% Desc</th>
                                                <th scope="col">Precio Desc.</th> 
                                                <th scope="col" title="Actualizar impuesto">Imp.</th>
                                                
                                                <th scope="col">Subtotal</th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <tr v-for="(line, index) in proforma.lines" :key="line.id">
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
                                        
                                                
                                                <!-- <td>
                                                    <input type="checkbox"
                                                           name="exo"
                                                           v-model="line.exo"
                                                           title="Exonerar Linea" @change="refreshLine(line, index)">
                                                </td> -->
                                                <th scope="row">{{ index + 1 }}</th>
                                                <td>{{ line.Codigo }}</td>
                                                <td>{{ line.Detalle }}</td>
                                                <td>{{ line.existencias ? line.existencias : 'Ingresado' }}</td>
                                                <td>
                                                    <input 
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        v-model="line.unidades"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields() || isCreatingNota"
                                                        >
                                                     <span v-else> {{ line.unidades }}</span>
                                                </td>
                                                
                                                <!-- <td>{{ line.UnidadMedida }}</td> -->
                                                <td>
                                                    <input 
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        v-model="line.precioUnidad"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields()"
                                                        >
                                                     <span v-else> {{ moneyFormat(line.precioUnidad) }}</span>
                                               
                                                </td>
                                               
                                                <td>
                                                    <input
                                                        class="form-control form-control-sm"
                                                        type="text" 
                                                        v-model="line.utilidad"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields()"
                                                        >
                                                    <span v-else> {{ line.utilidad }}</span>
                                                </td>
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
                                                <td>{{ moneyFormat(line.precio_con_descuento) }}</td>

                                                 <td class="py-2 px-2">
                                                     <button type="button" class="btn btn-success btn-sm" title="Impuestos" 
                                                     data-toggle="modal"
                                                    data-target="#taxesModal"
                                                     @click="showModalTaxes(line, index)" v-if="!disableFields() || isCreatingNota" >
                                                        Imp <span v-for="(tax, indexTax) in line.taxes" :key="indexTax"> ({{ tax.tarifa }}%)</span>
                                                    </button>
                                                </td>
                                                
                                            
                                                <td>{{ moneyFormat(line.SubTotal) }}</td>
                                              
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">SubTotal:</td>
                                                <td> {{ moneyFormat(proforma.TotalVentaNeta) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Descuentos:</td>
                                                <td> {{ moneyFormat(proforma.TotalDescuentos) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Impuestos:</td>
                                                <td> {{ moneyFormat(proforma.TotalImpuesto) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Total:</td>
                                                <td> {{ moneyFormat(SubTotalComprobante) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Ajuste:</td>
                                                <td><input
                                                        class="form-control form-control-sm"
                                                        type="text" 
                                                        v-model="proforma.ajuste"
                                                        @blur="calculateProforma(proforma.lines)"
                                                        @keydown.enter.prevent="calculateProforma(proforma.lines)"
                                                        v-if="!disableFields()"
                                                        ></td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Total con ajuste:</td>
                                                <td> {{ moneyFormat(proforma.TotalComprobante) }}</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                </div>
                               
                                
                            </div>
                        </div> <!--card productos-->

                         <div class="form-group buttons">
                            <button type="submit" class="btn btn-success" v-if="!disableFields()">Guardar</button>
                
                            <a :href="'/proformapurchases/'+ proforma.id +'/print'" class="btn btn-dark" v-if="proforma.id" role="button">Imprimir</a>
                             <a :href="'/proformapurchases/'+ proforma.id +'/ticket'" class="btn btn-dark" v-if="proforma.id" role="button">Ticket</a>

                           <button type="button" class="btn btn-dark" @click="requestEmail(proforma)" v-if="proforma.id">Enviar por correo</button>
                           
                            <a :href="'/purchases/create?p='+ proforma.id" class="btn btn-info" role="button" v-if="proforma.id">Generar Factura compra</a>
                            <a href="/proformapurchases" class="btn btn-light" role="button">Regresar</a>
                        </div>
                    </div>  <!--col-->
                    <!-- <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white"></div>

                            <div class="card-body">
                                
                                
                                
                            </div>
                        </div>
                    </div> -->


          
            </div>

        </form>

        <providers-modal @assigned="addProvider" :tipo-identificaciones="tipoIdentificaciones"></providers-modal>
        <products-modal @assigned="addProduct" :providers="providers" :medidas="medidas" :taxes="taxes"></products-modal>
        <taxes-modal @assigned="addTax" @remove="removeTax"></taxes-modal>

    </div>
    
</template>
<script>

import Loading from "./Loading.vue";
import ProvidersModal from "./ProvidersModal.vue";
import ProductsModal from "./ProductsModal.vue";
import TaxesModal from "./TaxesModal.vue";
import FormError from "./FormError.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
   props:['currentProforma','tipoDocumentos','medioPagos','condicionVentas','currentTipoDocumento','tipoIdentificaciones','providers','medidas','taxes'],
   data () {
       return {
           proforma:{
               TipoDocumento: this.currentTipoDocumento ? this.currentTipoDocumento : '01',
               fecha_factura: moment().format('YYYY-MM-DD'),
               factura_proveedor:'',
               provider_id:0,
               cliente:'',
               email:'',
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
               ajuste:0,
               lines:[],
               initialPayment:'',
               observations:'',
               opening: moment().format('YYYY-MM-DD hh:mm:ss'),
           },
           SubTotalComprobante:0,
           code:'',
           customerDiscount:0,
           loader: false,
           errors:[],
           configDate:{
                dateFormat:'Y-m-d'
            },
           
           
           
       }
   },
   components:{
       ProvidersModal,
       ProductsModal,
       TaxesModal,
       FormError,
       flatPickr,
       Loading
   },
   
   methods:{
        saleByUnid(line){
           
           return false;//line.fracciones_unidad <= 1;
       },
       disableFields(){
           
          return false//(this.proforma.id)
       },
       tipoDocumentoName(tipoDocumento){
           return _.get(this.tipoDocumentosNotas, tipoDocumento);
       },
       moneyFormat(n){
         
           if(typeof n === "number"){

                return '₡' + n.format(2);
           }

           return '₡' + n;
       },
       listenCliente(e){
          
           if(!e.target.value){
               this.proforma.provider_id = 0;
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
          
            axios.get(`/providers?q=${this.proforma.cliente}`)
                .then(({data}) => {
                    
                    this.proforma.provider_id = 0;
                    this.proforma.email = '';
                    //this.proforma.cliente = '';

                    if(data.data){
                        
                        if(data.data.length == 1){
                            this.addProvider(data.data[0]);
                             flash('Proveedor Agregado');
                             
                        }else{
                            $('#providersModal').modal();
                            window.events.$emit('showProvidersModal', { searchTerm: this.proforma.cliente})
                        }
                       
                    }else{
                        flash('Proveedor No encontrado', 'danger');
                    }
                })
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
       

       addProvider(proveedor){
          
           this.proforma.provider_id = proveedor.id
           this.proforma.cliente = proveedor.name
           this.proforma.email = proveedor.email
           this.proforma.tipo_identificacion_cliente = proveedor.tipo_identificacion
           this.proforma.identificacion_cliente = proveedor.identificacion
           let discount = parseFloat(proveedor.PorcentajeDescuento)

            this.providerDiscount = discount
           
         
           if(this.proforma.lines.length){
               this.proforma.lines.forEach((line, index) => {
                    line.PorcentajeDescuento = this.providerDiscount
                    this.refreshLine(line, index)
               });
             
           }

           this.checkFactura();

           
           
       },
       checkFactura(){
           this.errors = [];
           axios.get(`/proformapurchases/check?fac=${this.proforma.factura_proveedor}&provider=${this.proforma.provider_id}`)
                .then(({data}) => {
                  
                    if(data == 'exists'){
                         let error = {}
                       
                          error.factura_proveedor = ['Ya se encuentra una factura con este numero y este proveedor.']
                            
                        this.errors = error;
                        
                    }
                })
       },
       addProduct(product){
           this.createPurchaseLine(product)
           this.scrollToEnd();
          
       },
       removeLine(product, index){
            this.proforma.lines.splice(index, 1);
            this.calculateProforma(this.proforma.lines)
       },

       createPurchaseLine(product){
          

             let lineIndexFound = _.findIndex( this.proforma.lines, function(o) {
                    return o.Codigo === product.code;
             });
             let lineFound = _.find( this.proforma.lines, function(o) {
                    return o.Codigo === product.code;
             });

             if(lineFound && lineIndexFound !== -1)
             {
                lineFound.Cantidad++
   
                this.updateProformaLine(this.calculateProformaLine(lineFound), lineIndexFound);
                 
             }else{
               

                  let nuevo = {
                        CodigoProductoHacienda: product.CodigoProductoHacienda,
                        Codigo: product.code,
                        Detalle: product.name,
                        existencias: product.quantity,
                        Cantidad: 0,
                        unidades: 0,
                        UnidadMedida: product.measure,
                        precioUnidad: product.purchase_price ? product.purchase_price : 0,
                        PrecioUnitario: 0,
                        MontoTotal: 0,
                        utilidad: product.utilidad,
                        PorcentajeDescuento: this.customerDiscount,
                        MontoDescuento: 0,
                        NaturalezaDescuento:'',
                        SubTotal: 0,
                        MontoTotalLinea: 0,
                        totalTaxes:0,
                        taxes: product.taxes,
                        ingresado_inventario:0,
                        precio_con_descuento: 0,
                        product:product,
                        is_servicio_medico: product.is_servicio_medico,
                        overrideImp:false
                       
                    }
                  
                let line = this.calculateProformaLine(nuevo);

                 this.proforma.lines.push(line);
             }

            this.calculateProforma(this.proforma.lines)

       },

       refreshLine(line, index){
          this.updateProformaLine(this.calculateProformaLine(line, index), index);
          
       },

       updateProformaLine(line, index){
          
           this.proforma.lines.splice(index, 1, line);
           this.calculateProforma(this.proforma.lines)
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

                let MontoImpuesto = redondeo((parseFloat(tarifa)/100) * subTotal, 5); // se redondeo por problemas de decimales de hacienda
            
                ImpuestoNeto = MontoImpuesto;

                if(line.exo /* && (!this.invoice.id || this.isCreatingNota) */ ){
                    
                    PorcentajeExo = parseFloat(lineTax.PorcentajeExoneracion ? lineTax.PorcentajeExoneracion : 0);
                   
                    MontoExoneracion = redondeo((PorcentajeExo / 100) * MontoImpuesto, 5);
                

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

       calculateProformaLine(line, index){
           let price_sale = 0;
            line.unidades = parseFloat(line.unidades);
            line.precioUnidad= parseFloat(line.precioUnidad);
            
             line.Cantidad = line.unidades;
               
        
             line.PrecioUnitario = line.precioUnidad;
           
           
            line.PorcentajeDescuento = parseFloat(line.PorcentajeDescuento ? line.PorcentajeDescuento : 0);
        
            line.precio_con_descuento =  line.PrecioUnitario - ((line.PorcentajeDescuento / 100) * line.PrecioUnitario);
          
            price_sale = redondeo((line.precio_con_descuento * (line.utilidad) / 100) + line.precio_con_descuento);
         
            
            let taxes = [];
            let MontoTotal = line.PrecioUnitario * line.Cantidad;
            let MontoDescuento = (line.PorcentajeDescuento / 100) * MontoTotal;
            let SubTotal = MontoTotal - MontoDescuento;

            // if(line.PorcentajeDescuento2 > 0){
            //    let MontoDescuento2 = (line.PorcentajeDescuento2 / 100) * SubTotal;
            //    SubTotal = SubTotal - MontoDescuento2;
            //    MontoDescuento += MontoDescuento2;
            // }

            let BaseImponible = SubTotal;//line.BaseImponible ? parseFloat(line.BaseImponible) : SubTotal;
            let totalTaxes = 0;
            line.MontoTotal = MontoTotal;
            line.MontoDescuento = MontoDescuento;
            //line.NaturalezaDescuento ='';
            line.SubTotal = SubTotal;
            line.BaseImponible = BaseImponible;

            
              
              
             line.taxes.forEach(tax => {
                        
                        this.calculateExoneration(line, tax, index);

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
       calculateProforma(lines){
          
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
            let SubTotalComprobante = 0;

            lines.forEach(line => {
               
               if(line.type == 'P'){

                    if(line.taxes.length){
                        
                        line.taxes.forEach(tax => {
                            if(line.exo){
                                
                                
                                TotalMercanciasGravadas += (1-parseFloat(tax.PorcentajeExoneracion)/100) * line.MontoTotal;
                                  
                                TotalMercExonerada += (parseFloat(tax.PorcentajeExoneracion)/100) * line.MontoTotal

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
                                  
                                    
                                       
                                    TotalServGravados += (1-parseFloat(tax.PorcentajeExoneracion)/100) * line.MontoTotal;
                                    
                                    TotalServExonerado += (parseFloat(tax.PorcentajeExoneracion)/100) * line.MontoTotal;
                                   
                                 }else{
                                    TotalServGravados += parseFloat(line.MontoTotal);
                                    TotalServExonerado += 0;
                                }

                                
                                //IVA devuelto para servicios medicos pagados con tarjeta
                                if(line.is_servicio_medico && this.proforma.MedioPago == '02'){
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
            SubTotalComprobante = TotalVentaNeta + TotalImpuesto - TotalIVADevuelto;
           
            TotalComprobante = SubTotalComprobante - parseFloat(this.proforma.ajuste);

            this.proforma.TotalMercanciasGravadas = TotalMercanciasGravadas;
            this.proforma.TotalMercanciasExentas = TotalMercanciasExentas;
            this.proforma.TotalMercExonerada = TotalMercExonerada;
            this.proforma.TotalServGravados = TotalServGravados;
            this.proforma.TotalServExentos = TotalServExentos;
            this.proforma.TotalServExonerado = TotalServExonerado;
            this.proforma.TotalGravado = TotalGravado;
            this.proforma.TotalExento = TotalExento;
            this.proforma.TotalExonerado = TotalExonerado;
            this.proforma.TotalVenta = TotalVenta; 
            this.proforma.TotalDescuentos = TotalDescuentos;
            this.proforma.TotalVentaNeta = TotalVentaNeta;
            this.proforma.TotalImpuesto = TotalImpuesto;
            this.SubTotalComprobante = SubTotalComprobante;
            this.proforma.TotalIVADevuelto = TotalIVADevuelto;
            this.proforma.TotalComprobante = TotalComprobante;


            
           
            return this.proforma;


       },

       save(){
         if(!this.proforma.lines.length){
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
       persist(){
           if(this.proforma.id){

                axios.put(`/proformapurchases/${this.proforma.id}`, this.proforma)
                    .then(({data}) => {
                        
                        //this.clearForm();
                        flash('Factura Guardada Correctamente.');
                        this.$emit('updated', data);
                            
                        this.actions(data)


                    })
                    .catch(error => {
                        flash('Error al guardar la Factura!!', 'danger');
                         this.errors = error.response.data.errors ? error.response.data.errors : [];
                    });

           }else{

                axios.post(`/proformapurchases`, this.proforma)
                .then(({data}) => {
                    
                    this.clearForm();
                    flash('Factura Guardada Correctamente.');
                    this.$emit('created', data);

                    this.actions(data)


                })
                .catch(error => {

                    flash('Error al guardar la Factura!!', 'danger');
                     this.errors = error.response.data.errors ? error.response.data.errors : [];
                });

           }
          
       },
       requestEmail(proforma){
           Swal({
                title: 'Correo',
                input: 'text',
                inputPlaceholder: '',
                showCancelButton: true,
                confirmButtonText: 'Enviar',
                showLoaderOnConfirm: true,
                inputValue: proforma.email ? proforma.email : '',
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
                    
                    return axios.post('/proformapurchases/'+ proforma.id + '/pdf',{ to: email })
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
                       
                        })
                
                }
                

            });
       },
   
       actions(proforma){
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
                    window.location = '/proformapurchases/' + proforma.id + '/ticket'

                }else if(result.value == 2){
                    window.location = '/proformapurchases/' + proforma.id + '/print'
                }else if (result.dismiss === Swal.DismissReason.cancel) {
                    
                        this.requestEmail(purchase)
                    
                }else{
                    
                    window.location = '/proformapurchases'

                }


                

            });
       },
       clearForm(){

           this.proforma = {
               TipoDocumento: '01',
               fecha_factura: moment().format('YYYY-MM-DD'),
               factura_proveedor:'',
               provider_id:0,
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
               ajuste:0,
               lines:[],
               initialPayment:'',
               observations:''
               
           };

           this.code = '';
           this.providerDiscount = 0;
           
            

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
   mounted(){
        if(this.proforma.id && !this.proforma.opening){
            this.loader = true;
            axios.put(`/proformapurchases/${this.proforma.id}`, this.proforma)
                .then(({data}) => {
                    this.loader = false;
                    //this.clearForm();
                    flash('Cargada Correctamente.');
                    

                })
                .catch(error => {
                     this.loader = false;
                });
        }
   },
   created(){
       if(this.currentProforma){
           this.proforma = this.currentProforma;
           if(this.currentTipoDocumento){
               this.proforma.TipoDocumento = this.currentTipoDocumento
           }
           this.proforma.lines.forEach((line, index) => {
               line.updateStock = 0;
               this.refreshLine(line, index);
           });
           this.calculateProforma(this.proforma.lines)
       }
   }

}
</script>
