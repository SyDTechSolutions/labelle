<template>
    <div class="invoice-form">

        <form @submit.prevent="save()">
            <div class="row justify-content-between">
            
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white d-flex">
                                <div class="flex-grow-1">
                                    Proforma
                                </div>
                                <div v-if="isAdmin">
                                    <select class="form-control custom-select" name="created_by" id="created_by" v-model="proforma.created_by" @change="updateSeller()">
                                    
                                        <option v-for="(user, index) in users" :value="user.id" :key="index">
                                            {{ user.name }}
                                        </option>
                                        
                                        </select>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="TipoDocumento">Tipo Documento</label>
                                        <select class="form-control custom-select" name="TipoDocumento" id="TipoDocumento" v-model="proforma.TipoDocumento" :disabled="true">
                                    
                                        <option v-for="(value, key, index) in tipoDocumentos" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                
                                    <div class="form-group col-md-4">
                                        <label for="cliente">Nombre Cliente</label>
                                        <div class="input-group">
                                        
                                            <div class="input-group-prepend" v-if="!disableFields()">
                                                <button class="btn btn-outline-secondary" 
                                                type="button"
                                                data-toggle="modal"
                                                data-target="#customersModal"
                                                @click="showModalCustomers()">Buscar</button>
                                            </div>
                                            <input type="text" class="form-control" id="cliente" placeholder="" v-model="proforma.cliente" @keyup="listenCliente($event)" required :disabled="disableFields()">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" name="email" v-model="proforma.email" :disabled="disableFields()">
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                     <div class="form-group col-md-3">
                                        <label for="MedioPago">Medio Pago</label>
                                        <select class="form-control custom-select" name="MedioPago" id="MedioPago" v-model="proforma.MedioPago" :disabled="disableFields()" @change="calculateProforma(proforma.lines)">
                                    
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
                                                name="PlazoCredito"
                                                :disabled="proforma.CondicionVenta != '02' || disableFields()"
                                                >
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
                                        
                                        <template v-for="(line, index) in proforma.lines">
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
                                                <td>
                                                    {{ line.UnidadMedida }}
                                                </td>
                                                <td>
                                                    <input 
                                                        class="form-control form-control-sm"
                                                        type="text"
                                                        v-model="line.PrecioUnitario"
                                                        @blur="refreshLine(line, index)"
                                                        @keydown.enter.prevent="refreshLine(line, index)"
                                                        v-if="!disableFields()"
                                                        >
                                                     <span v-else> {{ line.PrecioUnitario }}</span>
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
                                            
                                                <td>{{ moneyFormat(line.SubTotal) }}</td>
                                              
                                            </tr>
                                            <tr v-show="line.exo">
                                                <td colspan="11">
                                                    <div class="box-exo">
                                                        <div v-for="(tax, indexTax) in line.taxes" :key="tax.id" >

                                                            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" :data-target="'#collapseTax'+ index + indexTax" aria-expanded="false" :aria-controls="'collapseTax'+ index + indexTax">
                                                                {{ numberFormat(tax.PorcentajeExoneracion) }}% Exo
                                                            </button>
                                                            <div :class="'collapse multi-collapse-line'+ index" :id="'collapseTax'+ index + indexTax">
                                                                <div class="card card-body">
                                                                    <h4>Exoneración Impuesto {{ numberFormat(tax.TarifaOriginal) }}%</h4>
                                                                    <div class="form-row">
                                                                    
                                                                        <div class="form-group col-md-3">
                                                                            <label for="TipoDocumento">Tipo Documento</label>
                                                                            <select class="form-control custom-select" name="TipoDocumento"  v-model="tax.TipoDocumento" :disabled="disableFields() && !isCreatingNota">
                                                                            
                                                                            <option v-for="(value, key) in tipoDocumentosExo" :value="key" :key="key">
                                                                                {{ value }}
                                                                            </option>
                                                                            
                                                                            </select>
                                                                             <form-error v-if="errors.TipoDocumento" :errors="errors" style="float:right;">
                                                                                {{ errors.TipoDocumento[0] }}
                                                                            </form-error>
                                                                            
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="NumeroDocumento">Numero Documento</label>
                                                                        
                                                                            <input type="text" class="form-control" id="NumeroDocumento" placeholder="" v-model="tax.NumeroDocumento" :disabled="disableFields() && !isCreatingNota" >
                                                                                
                                                                            <form-error v-if="errors.NumeroDocumento" :errors="errors" style="float:right;">
                                                                                {{ errors.NumeroDocumento[0] }}
                                                                            </form-error>
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-6">
                                                                            <label for="NombreInstitucion">Nombre institución</label>
                                                                        
                                                                            <input type="text" class="form-control" id="NombreInstitucion" placeholder="" v-model="tax.NombreInstitucion" :disabled="disableFields() && !isCreatingNota"  >
                                                                                
                                                                            <form-error v-if="errors.NombreInstitucion" :errors="errors" style="float:right;">
                                                                                {{ errors.NombreInstitucion[0] }}
                                                                            </form-error>
                                                                        </div>
                                                                        
                                                                        <div class="form-group col-md-3">
                                                                            <label for="FechaEmision">Fecha Emisión</label>
                                                                        
                                                                            <flat-pickr
                                                                                    v-model="tax.FechaEmision"                                             
                                                                                    class="form-control" 
                                                                                    placeholder="Select date"               
                                                                                    name="date">
                                                                            </flat-pickr>
                                                                            <form-error v-if="errors.FechaEmision" :errors="errors" style="float:right;">
                                                                                {{ errors.FechaEmision[0] }}
                                                                            </form-error>
                                                                        </div>

                                                                        <div class="form-group col-md-3">
                                                                            <label for="PorcentajeExoneracion">Porcentaje Exo.(0-13%)</label>
                                                                        
                                                                            <input type="number" class="form-control" min="0" max="13" id="PorcentajeExoneracion" placeholder="" v-model="tax.PorcentajeExoneracion"
                                                                            @blur="addExoneration(line, tax, index)"
                                                                            @keydown.enter.prevent="addExoneration(line, tax, index)" :disabled="disableFields() && !isCreatingNota" >
                                                                                
                                                                            <form-error v-if="errors.PorcentajeExoneracion" :errors="errors" style="float:right;">
                                                                                {{ errors.PorcentajeExoneracion[0] }}
                                                                            </form-error>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <label for="MontoExoneracion">Monto Exoneración</label>
                                                                        
                                                                            <input type="text" class="form-control" id="MontoExoneracion" placeholder="" v-model="tax.MontoExoneracion" disabled >
                                                                                
                                                                            <form-error v-if="errors.MontoExoneracion" :errors="errors" style="float:right;">
                                                                                {{ errors.MontoExoneracion[0] }}
                                                                            </form-error>
                                                                        </div>

                                                                        <div class="form-group col-md-3">
                                                                            <label for="ImpuestoNeto">Impuesto Neto</label>
                                                                        
                                                                            <input type="text" class="form-control" id="ImpuestoNeto" placeholder="" v-model="tax.ImpuestoNeto" disabled >
                                                                                
                                                                            <form-error v-if="errors.ImpuestoNeto" :errors="errors" style="float:right;">
                                                                                {{ errors.ImpuestoNeto[0] }}
                                                                            </form-error>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" :data-target="'#collapseTax'+ index + indexTax" aria-expanded="false" :aria-controls="'collapseTax'+ index + indexTax">
                                                                                Cerrar
                                                                            </button>
                                                                        </div>
                                                                        <div class="form-group col-md-3">
                                                                             <input type="checkbox"
                                                                            name="exoall"
                                                                            v-model="exoall"
                                                                            title="Aplicar Exoneracion a todas las lineas" @change="allLinesExo(line, tax, index)"> Aplicar Exoneracion a todas las lineas?
                                                                        </div>
                                                                    
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        
                            
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </template>
                                            <tr>
                                                <td colspan="11" class="text-right">SubTotal:</td>
                                                <td> {{ moneyFormat(proforma.TotalVentaNeta) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Impuestos:</td>
                                                <td> {{ moneyFormat(proforma.TotalImpuesto) }} </td>
                                            </tr>
                                            <tr v-show="proforma.MedioPago == '02'">
                                                <td colspan="11" class="text-right">IVA Devuelto:</td>
                                                <td> -{{ moneyFormat(proforma.TotalIVADevuelto) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="11" class="text-right">Total:</td>
                                                <td> {{ moneyFormat(proforma.TotalComprobante) }}</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                </div>
                               
                                
                            </div>
                        </div> <!--card productos-->

                         <div class="form-group">
                            <button type="submit" class="btn btn-success" v-if="!disableFields()">Guardar</button>
                
                            <a :href="'/proformas/'+ proforma.id +'/print'" class="btn btn-dark" v-if="proforma.id" role="button">Imprimir</a>
                             <a :href="'/proformas/'+ proforma.id +'/ticket'" class="btn btn-dark" v-if="proforma.id" role="button">Ticket</a>

                           <button type="button" class="btn btn-dark" @click="requestEmail(proforma)" v-if="proforma.id">Enviar por correo</button>
                            <a href="/proformas/create" class="btn btn-primary" role="button" v-if="proforma.id">Nueva proforma</a>
                            <a :href="'/invoices/create?p='+proforma.id" class="btn btn-success" role="button" v-if="proforma.id">Generar Factura</a>
                            <a href="/proformas" class="btn btn-light" role="button">Regresar</a>
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

        <customers-modal @assigned="addCliente"></customers-modal>
        <products-modal @assigned="addProduct"></products-modal>
         <taxes-modal @assigned="addTax" @remove="removeTax"></taxes-modal>

    </div>
    
</template>
<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import CustomersModal from "./CustomersModal.vue";
import ProductsModal from "./ProductsModal.vue";
import TaxesModal from "./TaxesModal.vue";
import FormError from "./FormError.vue";
export default {
   props:['currentProforma','tipoDocumentos','medioPagos','condicionVentas','currentTipoDocumento','tipoDocumentosExo','users','currentUser'],
   data () {
       return {
           proforma:{
               TipoDocumento: this.currentTipoDocumento ? this.currentTipoDocumento : '01',
               customer_id:0,
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
               lines:[],
               initialPayment:'',
               observations:'',
               created_by: this.currentUser ? this.currentUser.id : 0
           },
          
           code:'',
           customerDiscount:0,
           errors:[],
           exoall:false,
          
           
           
       }
   },
   components:{
       CustomersModal,
       ProductsModal,
       TaxesModal,
       FormError,
       flatPickr
   },
   computed:{
       isAdmin(){
           return window.App.isAdmin;
       }
   },
   
   methods:{
       updateSeller(){
           if(this.proforma.id){
               
                axios.put(`/proformas/${this.proforma.id}/updateseller`, this.proforma)
                    .then(data => {
                       
                      flash('Vendedor actualizado Agregado');
                       
                    });
           }
           
       },
       disableFields(){
           
          return false//(this.proforma.id)
       },
       tipoDocumentoName(tipoDocumento){
           return _.get(this.tipoDocumentosNotas, tipoDocumento);
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
               this.proforma.customer_id = 0;
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
       showModalCustomers(){
         
               window.events.$emit('showCustomersModal')
   
       },
        showModalProducts(){
         
                 window.events.$emit('showProductsModal')
   
       },
       searchProduct(){
        
            axios.get(`/products?code=${this.code}`)
                .then(data => {
                    if(data.data){
                        this.addProduct(data.data)
                        flash('Producto Agregado');
                    }else{
                        flash('Producto No encontrado', 'danger');
                    }
                })
       },
       

       addCliente(cliente){
           this.proforma.customer_id = cliente.id
           this.proforma.cliente = cliente.name
           this.proforma.email = cliente.email
           let discount = parseFloat(cliente.PorcentajeDescuento)

            this.customerDiscount = discount
           
         
           if(this.proforma.lines.length){
               this.proforma.lines.forEach((line, index) => {
                    line.PorcentajeDescuento = this.customerDiscount
                    this.refreshLine(line, index)
               });
             
           }
           
       },
       addProduct(product){
           this.createProformaLine(product)
          
       },
       removeLine(product, index){
            this.proforma.lines.splice(index, 1);
            this.calculateProforma(this.proforma.lines)
       },

       createProformaLine(product){
             

             let lineIndexFound = _.findIndex( this.proforma.lines, function(o) {
                    return o.Codigo === product.code;
             });
             let lineFound = _.find( this.proforma.lines, function(o) {
                    return o.Codigo === product.code;
             });

             if(lineFound && lineIndexFound !== -1)
             {
                lineFound.Cantidad++
   
                this.updateProformaLine(this.calculateProformaLine(lineFound, lineIndexFound), lineIndexFound);
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
        allLinesExo(lineInvoice, lineTax, lineInvoiceindex){
           
           this.proforma.lines.forEach((line, index) => {
               
            if(this.exoall){
                    line.exo = true;
                    line.taxes.forEach(tax => {
                        tax.name = tax.name;
                        tax.tarifa = lineTax.tarifa;
                        tax.TipoDocumento = lineTax.TipoDocumento;
                        tax.NumeroDocumento = lineTax.NumeroDocumento;
                        tax.NombreInstitucion = lineTax.NombreInstitucion;
                        tax.FechaEmision = lineTax.FechaEmision;
                        tax.PorcentajeExoneracion = lineTax.PorcentajeExoneracion;
                        tax.ImpuestoOriginal = lineTax.ImpuestoOriginal;
                        tax.TarifaOriginal = tax.TarifaOriginal;
                        
                
                    });
                }else{
                    if(index != lineInvoiceindex){
                        line.exo = false;
                        line.taxes.forEach(tax => {
                            
                            tax.name = tax.name;
                            tax.tarifa = tax.TarifaOriginal;
                            tax.amount = tax.ImpuestoOriginal;
                            tax.TipoDocumento = '';
                            tax.NumeroDocumento = '';
                            tax.NombreInstitucion = '';
                            tax.FechaEmision = null;
                            tax.PorcentajeExoneracion = 0;
                            tax.MontoExoneracion = 0;
                            tax.ImpuestoOriginal = tax.ImpuestoOriginal;
                            
                    
                        });
                    }
                  
                }

                 this.refreshLine(line, index);
           });
       },
       showExo(line, index){
           
           $('.multi-collapse-line'+ index).addClass('show');

           if(!line.exo){
               //line.taxes = line.product.taxes;
               line.taxes.forEach(tax => {
                   tax.name = tax.name;
                   tax.tarifa = tax.TarifaOriginal;
                   tax.amount = tax.ImpuestoOriginal;
                   tax.MontoExoneracion = 0;
                   tax.PorcentajeExoneracion = 0;
                   tax.ImpuestoNeto = tax.ImpuestoOriginal;
        
               });
              
           }
           

           this.refreshLine(line, index);
       },
       
       addExoneration(line, lineTax, index){
           
          if(!this.proforma.id || this.isCreatingNota){
            this.calculateExoneration(line, lineTax, index);
          }
          this.updateProformaLine(this.calculateProformaLine(line, index), index);
          
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

       calculateProformaLine(line, index){
            
            line.Cantidad = parseFloat(line.Cantidad);
            line.PrecioUnitario = parseFloat(line.PrecioUnitario);
            line.PorcentajeDescuento = parseFloat(line.PorcentajeDescuento ? line.PorcentajeDescuento : 0);

            let taxes = [];
            let MontoTotal = line.PrecioUnitario * line.Cantidad;
            let MontoDescuento = redondeo((line.PorcentajeDescuento / 100) * MontoTotal, 5);
            let SubTotal = MontoTotal - MontoDescuento;
            let BaseImponible = SubTotal;//line.BaseImponible ? parseFloat(line.BaseImponible) : SubTotal;
            let totalTaxes = 0;

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

           
           
            
            // line.MontoTotal = MontoTotal;
            // line.MontoDescuento = MontoDescuento;
            // line.NaturalezaDescuento ='';
            // line.SubTotal = SubTotal;
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
            TotalComprobante = TotalVentaNeta + TotalImpuesto - TotalIVADevuelto;

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
            this.proforma.TotalIVADevuelto = TotalIVADevuelto;
            this.proforma.TotalComprobante = TotalComprobante;

            
           
            return this.proforma;


       },

       save(){

            let errorM = {};
           this.proforma.lines.forEach(line => {
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
         
        this.persist();
           
       },
       persist(){
           if(this.proforma.id){

                axios.put(`/proformas/${this.proforma.id}`, this.proforma)
                    .then(({data}) => {
                        
                        //this.clearForm();
                        flash('Proforma Guardada Correctamente.');
                        this.$emit('updated', data);
                            
                        this.actions(data)


                    })
                    .catch(error => {
                        flash('Error al guardar la Proforma!!', 'danger');
                    });

           }else{

                axios.post(`/proformas`, this.proforma)
                .then(({data}) => {
                    
                    this.clearForm();
                    flash('Proforma Guardada Correctamente.');
                    this.$emit('created', data);

                    this.actions(data)


                })
                .catch(error => {
                    flash('Error al guardar la Proforma!!', 'danger');
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
                    
                    return axios.post('/proformas/'+ proforma.id + '/pdf',{ to: email })
                        .then(resp => {})
                        .catch(error =>{
                           
                            Swal.showValidationError(
                                `Request failed: ${error}`
                                )
                                
                            flash('Error al enviar la Proforma por correo!!', 'danger');
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
                
            })
            .then( (result) => {
            
            
                if (result.value) {

                     Swal({
                        title: `Proforma Enviada Correctamente`,
                       
                        })
                
                }
                

            });
       },
   
       actions(proforma){
           Swal({
                title: 'Proforma Guardada',
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
                    window.location = '/proformas/' + proforma.id + '/ticket'

                }else if(result.value == 2){
                    window.location = '/proformas/' + proforma.id + '/print'
                }else if (result.dismiss === Swal.DismissReason.cancel) {
                    
                        this.requestEmail(proforma)
                    
                }else{
                    
                    window.location = '/proformas'

                }


                

            });
       },
       clearForm(){

           this.proforma = {
               TipoDocumento: '01',
               customer_id:0,
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
               lines:[],
               initialPayment:'',
               observations:'',
               created_by: this.currentUser ? this.currentUser.id : 0
               
           };

           this.code = '';
           this.customerDiscount = 0;

            

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
