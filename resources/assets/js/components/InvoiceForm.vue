<template>
    <div class="invoice-form" @keydown="handleKeydown">
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
                                    Facturación
                                </div>
                                <div v-if="isAdmin">
                                    <select class="form-control custom-select" name="created_by" id="created_by" v-model="invoice.created_by" @change="updateSeller()">
                                    
                                        <option v-for="(user, index) in users" :value="user.id" :key="index">
                                            {{ user.name }}
                                        </option>
                                        
                                        </select>
                                </div>

                                <div class="mx-1">
                                    <select class="form-control custom-select" name="C" id="CodigoMoneda" v-model="invoice.CodigoMoneda" @change="changeCurrency()">
                                    
                                        <option value="USD">
                                            Dólares
                                        </option>

                                        <option value="CRC">
                                            Colones
                                        </option>
                                        
                                    </select>
                                </div>
                                
                            </div>

                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="TipoDocumento">Tipo Documento</label>
                                        <select class="form-control custom-select border-dark" name="TipoDocumento" id="TipoDocumento" v-model="invoice.TipoDocumento" :disabled="disableFields()">
                                    
                                            <option v-for="(value, key, index) in tipoDocumentos" :value="key" :key="index">
                                                {{ value }}
                                            </option>
                                        
                                        </select>
                                    </div>
                                
                                     <div class="form-group col-md-6">
                                        <label for="MedioPago">Medio Pago</label>
                                        <select class="form-control custom-select border-dark" name="MedioPago" id="MedioPago" v-model="invoice.MedioPago" :disabled="disableFields()" @change="calculateInvoice(invoice.lines)">
                                    
                                        <option
                                        v-for="(value, key, index) in medioPagos" 
                                        :value="key" 
                                        :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label for="CondicionVenta">Condición de venta</label>
                                        <select class="form-control custom-select border-dark" name="CondicionVenta" id="CondicionVenta" v-model="invoice.CondicionVenta" :disabled="disableFields()">
                                    
                                            <option 
                                            v-for="(value, key, index) in condicionVentas" 
                                            :value="key" 
                                            :key="index">
                                                {{ value }}
                                            </option>
                                        
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="PlazoCredito">Plazo de credito</label>
                                        <!-- <input type="text" class="form-control" name="PlazoCredito" v-model="invoice.PlazoCredito" :disabled="invoice.CondicionVenta != '02' || disableFields()" > -->
                                         <flat-pickr
                                                v-model="invoice.PlazoCredito"                                             
                                                class="form-control border-dark" 
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
                                        <input type="text" class="form-control border-dark" name="initialPayment" v-model="invoice.initialPayment" :disabled="invoice.CondicionVenta != '02' || disableFields()" >
                                    </div>
                                </div>
                                <div class="form-row">
                                   
                                
                                    <div class="form-group col-md-12">
                                        <label for="observations">Observaciones</label>
                                         <textarea name="observations" class="form-control border-dark" v-model="invoice.observations" cols="30" rows="1" :disabled="disableFields()"></textarea>
                                       
                                            
                                        <form-error v-if="errors.observations" :errors="errors" style="float:right;">
                                            {{ errors.observations[0] }}
                                        </form-error>
                                    </div>
                                    
                                
                                </div>
                                
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Receptor
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                     <div class="form-group col-md-4">
                                        <label for="tipo_identificacion_cliente">Tipo Identificacion</label>
                                        <select class="form-control custom-select border-dark" name="tipo_identificacion_cliente" id="tipo_identificacion_cliente" v-model="invoice.tipo_identificacion_cliente" @change="changeTipoIdentificacion()" >
                                        
                                        <option value=""></option>
                                        <option v-for="(value, key, index) in tipoIdentificaciones" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                        <form-error v-if="errors.tipo_identificacion_cliente" :errors="errors" style="float:right;">
                                            {{ errors.tipo_identificacion_cliente[0] }}
                                        </form-error>
                                    </div>
                                
                                    <div class="form-group col-md-4">
                                        <label for="identificacion_cliente">Identificacion</label>
                                       
                                        <input type="text" class="form-control border-dark" id="identificacion_cliente" placeholder="" v-model="invoice.identificacion_cliente" @keyup="listenCliente($event)" >
                                            
                                        <form-error v-if="errors.identificacion_cliente" :errors="errors" style="float:right;">
                                            {{ errors.identificacion_cliente[0] }}
                                        </form-error>
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
                                            <input type="text" class="form-control border-dark" id="cliente" placeholder="" v-model="invoice.cliente" @keyup="listenCliente($event)" :disabled="disableFields()">
                                            
                                        </div>
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                    <div class="form-group col-md-3" v-if="invoice.TipoDocumento == '01'">
                                        <label for="CodigoActividadReceptor">Código de Actividad</label>
                                       
                                        <input type="text" 
                                        class="form-control" 
                                        id="CodigoActividadReceptor" placeholder="" 
                                        v-model="invoice.CodigoActividadReceptor">

                                        <form-error v-if="errors.CodigoActividadReceptor" :errors="errors" style="float:right;">
                                            {{ errors.CodigoActividadReceptor[0] }}
                                        </form-error>
                                    </div>
                                    
                                    <div class="form-group"
                                    :class="invoice.TipoDocumento == '01' ? 'col-md-9' : 'col-md-12'">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" v-model="invoice.email" >
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header bg-default">Agregar Productos
                                <div class="input-group">
                                        
                                    <div class="input-group-prepend" v-if="!disableFields() || isCreatingNota">
                                        <button class="btn btn-outline-secondary" 
                                        type="button"
                                        data-toggle="modal"
                                        data-target="#productsModal"
                                        @click="showModalProducts()">Buscar</button>
                                    </div>
                                    <input type="text" 
                                    class="form-control border-dark" 
                                    name="code" id="codeProduct" 
                                    placeholder="Codigo" 
                                    v-model="code" 
                                    autofocus 
                                    @keydown.prevent.enter="searchProduct()" 
                                    :disabled="disableFields() && !isCreatingNota">
                                    <div hidden><button class="btn btn-outline-secondary" 
                                        type="button" @click="addCode()" id="btnCode">Agregar</button>
                                    </div>
                                    <span class="input-group-btn"> 
                                        <button class="btn btn-dark" type="button" data-toggle="modal" data-target="#livestream_scanner">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="23"  height="23"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7v-1a2 2 0 0 1 2 -2h2" /><path d="M4 17v1a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v1" /><path d="M16 20h2a2 2 0 0 0 2 -2v-1" /><path d="M5 12l14 0" /></svg>
                                        </button> 
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="">
                                    <button 
                                    type="button"
                                    class="btn btn-dark mb-2"
                                    style="font-size: 14px;"
                                    @click="cleanInvoiceLines()">
                                        Limpiar lineas
                                    </button>

                                    <div class="d-flex justify-content-end mb-2">
                                        <div class="" style="width: 100px;">
                                            <div class="form-group">
                                                <label for="descuentoGeneral">Subtotal:</label>
                                                <p> {{ moneyFormat(invoice.TotalVentaNeta,symbol) }} </p>
                                            </div>
                                        </div>
                                        <div style="width: 100px;">
                                            <div class="form-group">
                                                <label for="descuentoGeneral">Descuentos:</label>
                                                <p> {{ moneyFormat(invoice.TotalDescuentos,symbol) }} </p>
                                            </div>
                                        </div>
                                        <div style="width: 100px;">
                                            <div class="form-group">
                                                <label for="descuentoGeneral">Impuestos:</label>
                                                <p> {{ moneyFormat(invoice.TotalImpuesto,symbol) }} </p>
                                            </div>
                                        </div>
                                        <div style="width: 100px;" v-show="invoice.MedioPago == '02'">
                                            <div class="form-group">
                                                <label for="descuentoGeneral">IVA Devuelto:</label>
                                                <p> -{{ moneyFormat(invoice.TotalIVADevuelto,symbol) }} </p>
                                            </div>
                                        </div>
                                        <div style="width: 100px;">
                                            <div class="form-group">
                                                <label for="descuentoGeneral">Total:</label>
                                                <p>{{ moneyFormat(invoice.TotalComprobante,symbol) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                            <th scope="col"></th>
                                             <th scope="col" title="Actualizar impuesto">Imp.</th>
                                            <th scope="col" v-if="isCreatingNota" title="Actualizar stock del inventario">Act. Inven.</th>
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
                                                            v-if="!disableFields() || isCreatingNota"
                                                            >
                                                            <span class="oi oi-delete"></span>
                                                        </button>
                                                    </td>
                                                    <td class="py-2 px-2">
                                                        <button type="button" class="btn btn-success btn-sm" title="Impuestos" 
                                                        data-toggle="modal"
                                                        data-target="#taxesModal"
                                                        @click="showModalTaxes(line, index)" v-if="!disableFields() || isCreatingNota" >
                                                            Imp
                                                        </button>
                                                        <div class="flex gap-2" v-if="currentInvoice && currentInvoice.id">
                                                            <span class="text-center" v-for="tax in line.taxes">
                                                                {{ tax.tarifa ? tax.tarifa + '% ' : '' }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td v-if="isCreatingNota">
                                                        <input type="checkbox"
                                                            name="updateStock"
                                                            v-model="line.updateStock"
                                                            title="Actualizar stock del inventario">
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
                                                            v-if="!disableFields() || isCreatingNota"
                                                            >
                                                        <span v-else> {{ line.Cantidad }}</span>
                                                    </td>
                                                    <td>{{ line.UnidadMedida }}</td>
                                                    <td>{{ moneyFormat(line.PrecioUnitario,symbol) }}</td>
                                                    <td>
                                                        <input
                                                            class="form-control form-control-sm"
                                                            type="text" 
                                                            v-model="line.PorcentajeDescuento"
                                                            @blur="refreshLine(line, index)"
                                                            @keydown.enter.prevent="refreshLine(line, index)"
                                                            v-if="!disableFields() || isCreatingNota"
                                                            >
                                                        <span v-else> {{ line.PorcentajeDescuento }}</span>
                                                    </td>
                                                
                                                    <td>{{ moneyFormat(line.SubTotal,symbol) }}</td>
                                                    <!-- No aplica para este negocio -->
                                                    <!-- <td>
                                                        <input
                                                            class="form-control form-control-sm"
                                                            type="text" 
                                                            v-model="line.BaseImponible"
                                                            @blur="refreshLine(line, index)"
                                                            @keydown.enter.prevent="refreshLine(line, index)"
                                                            v-if="!disableFields() || isCreatingNota"
                                                            >
                                                        <span v-else> {{ line.BaseImponible }}</span>
                                                    </td> -->
                                            
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
                                            
                                            <!-- <tr>
                                                <td :colspan="isCreatingNota ? 12 : 11" class="text-right">SubTotal:</td>
                                                <td> {{ moneyFormat(invoice.TotalVentaNeta,symbol) }} </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="isCreatingNota ? 12 : 11" class="text-right">Descuentos:</td>
                                                <td> {{ moneyFormat(invoice.TotalDescuentos,symbol) }} </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="isCreatingNota ? 12 : 11" class="text-right">Impuestos:</td>
                                                <td> {{ moneyFormat(invoice.TotalImpuesto,symbol) }} </td>
                                            </tr>
                                            <tr v-show="invoice.MedioPago == '02'">
                                                <td :colspan="isCreatingNota ? 12 : 11" class="text-right">IVA Devuelto:</td>
                                                <td> -{{ moneyFormat(invoice.TotalIVADevuelto,symbol) }} </td>
                                            </tr>
                                            <tr>
                                                <td :colspan="isCreatingNota ? 12 : 11" class="text-right">Total:</td>
                                                <td> {{ moneyFormat(invoice.TotalComprobante,symbol) }}</td>
                                            </tr> -->
                                            <tr>
                                                <td :colspan="isCreatingNota ? 12 : 11" class="text-right">Valor del Dolar:</td>
                                                <td> 
                                                    <span v-if="!isUpdatingCurrency"> {{ moneyFormat(dolar_value,"₡") }}</span>
                                                    
                                                    <div v-if="isUpdatingCurrency && !this.currentInvoice">
                                                        <input type="number" style="width: 70px;" v-model="dolar_value" />
                                                    </div>
                                                    <svg id="save_check" v-if="isUpdatingCurrency" @click="updateCurrency()" style="width: 18px; height: 20px; margin-top: 2px; margin-left: 5px; color: rgba(0, 0, 0, 0.651);" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>

                                                    <svg id="cancel" v-if="isUpdatingCurrency" @click="isUpdatingCurrency = false" style="width: 18px; height: 20px; margin-top: 2px; margin-left: 5px; color: rgba(0, 0, 0, 0.651);"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>

                                                    <svg id="edit" v-if="!isUpdatingCurrency && !this.currentInvoice" @click="isUpdatingCurrency = true" style="width: 18px; height: 20px; margin-top: 2px; margin-left: 5px; color: rgba(0, 0, 0, 0.651);" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                                        <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
                                                        <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
                                                    </svg>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                 <button type="button" class="btn btn-default" @click="showReferencias = !showReferencias" v-if="!invoice.id">Agregar Referencia</button>
                            </div>
                        </div> <!--card productos-->

                        <div class="card" v-if="isCreatingNota || invoice.referencias.length || showReferencias">
                            <div class="card-header bg-primary text-white">
                                Documentos Referencias
                            </div>
                            <div class="card-body">
                                <div class="form-referencias" v-show="isCreatingNota || showReferencias">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="TipoDocumento">Tipo Documento</label>
                                            <select class="form-control custom-select" name="TipoDocumento" id="TipoDocumento" v-model="referencia.TipoDocumento" :disabled="disableFields()">
                                        
                                            <option v-for="(value, key, index) in tipoDocumentos" :value="key" :key="index">
                                                {{ value }}
                                            </option>
                                            
                                            </select>
                                            <form-error v-if="errors.TipoDocumento" :errors="errors" style="float:right;">
                                                {{ errors.TipoDocumento[0] }}
                                            </form-error>
                                        </div>
                                    
                                        <div class="form-group col-md-4">
                                            <label for="NumeroDocumento">Número Documento</label>
                                            
                                            <input type="text" class="form-control" id="NumeroDocumento" placeholder="" v-model="referencia.NumeroDocumento">
                                            <form-error v-if="errors.NumeroDocumento" :errors="errors" style="float:right;">
                                                {{ errors.NumeroDocumento[0] }}
                                            </form-error>    
                                            
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="FechaEmision">Fecha Emisión</label>
                                            <input type="text" class="form-control" name="FechaEmision" v-model="referencia.FechaEmision" placeholder="YYYY-MM-DD HH:MM">
                                            <!-- <flat-pickr
                                                v-model="referencia.FechaEmision"                                         :config="configDateReferencia"   
                                                class="form-control" 
                                                placeholder="Selecione una fecha"               
                                                name="FechaEmision">
                                            </flat-pickr> -->
                                            <form-error v-if="errors.FechaEmision" :errors="errors" style="float:right;">
                                                {{ errors.FechaEmision[0] }}
                                            </form-error>    
                                        </div>
                                    
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="CodigoReferencia">Código Referencia</label>
                                            <select class="form-control custom-select" name="CodigoReferencia" id="CodigoReferencia" v-model="referencia.CodigoReferencia">
                                        
                                            <option v-for="(value, key, index) in codigoReferencias" :value="key" :key="index">
                                                {{ value }}
                                            </option>
                                            
                                            </select>
                                            <form-error v-if="errors.CodigoReferencia" :errors="errors" style="float:right;">
                                                {{ errors.CodigoReferencia[0] }}
                                            </form-error>   
                                        </div>
                                    
                                        <div class="form-group col-md-6">
                                            <label for="Razon">Razón</label>
                                            
                                            <input type="text" class="form-control" id="Razon" placeholder="" v-model="referencia.Razon">
                                             <form-error v-if="errors.Razon" :errors="errors" style="float:right;">
                                                {{ errors.Razon[0] }}
                                            </form-error>      
                                            
                                        </div>

                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" @click="addReferencia()">Agregar Referencia</button>
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="table-responsive" v-show="invoice.referencias.length">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Número documento</th>
                                                <th scope="col">Tipo de documento</th>
                                                <th scope="col">Código Referencia</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col"></th>
                                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        <tr v-for="(ref, index) in invoice.referencias" :key="ref.id">
                                                
                                                <td>{{ ref.NumeroDocumento }}</td>
                                                <td>{{ tipoDocumentoName(ref.TipoDocumento) }}</td>
                                                <td>{{ tipoCodigoReferenciaName(ref.CodigoReferencia) }}</td>
                                                <td>
                                                    {{ ref.FechaEmision }}
                                                </td>
                                                <td>
                                                    <button 
                                                        type="button" 
                                                        @click="removeReferencia(ref, index)" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        v-if="!disableFields() || isCreatingNota"
                                                        >
                                                        <span class="oi oi-delete"></span>
                                                    </button>
                                                </td>
                                              
                                            </tr>
                                            
                                        </tbody>
                                        </table>
                                </div>
                            </div>
                        </div> <!--card referencias-->

                         <div class="form-group">
                            <button id="submit-button" type="submit" class="btn btn-success" v-if="!disableFields() || isCreatingNota">Guardar</button>
                            <a :href="'/invoices/'+ invoice.id +'/notacredito'" class="btn btn-info" v-if="invoice.id && (invoice.TipoDocumento == '01' || invoice.TipoDocumento == '04')" role="button">Nota de Crédito</a>
                            <a :href="'/invoices/'+ invoice.id +'/notadebito'" class="btn btn-primary" v-if="invoice.id && (invoice.TipoDocumento == '01' || invoice.TipoDocumento == '04')" role="button">Nota de Débito</a>
                            <a :href="'/invoices/'+ invoice.id +'/recibopago'" class="btn btn-primary" v-if="invoice.id && (invoice.CondicionVenta == '02')" role="button">Recibo de Pago</a>
                            <button type="button" class="btn btn-dark" @click="requestEmail(invoice)" v-if="invoice.id">Enviar por correo</button>
                            <a :href="'/invoices/'+ invoice.id +'/print'" class="btn btn-dark" v-if="invoice.id" role="button">Imprimir</a>
                            <a :href="'/invoices/'+ invoice.id +'/ticket'" class="btn btn-dark" v-if="invoice.id" role="button">Ticket</a>
                        
                            <a href="/invoices" class="btn btn-light" role="button">Regresar</a>
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
        <barcode-scanner></barcode-scanner> 
        <modal-resumen-factura :medio-pagos="medioPagos" :currency="invoice.CodigoMoneda" :dolar-value="dolar_value" @recalculateInvoice="calculateInvoice(invoice.lines)" @saveResumenFactura="persist()"></modal-resumen-factura>
        <taxes-modal @assigned="addTax" @remove="removeTax"></taxes-modal>

    </div>
    
</template>
<script>

import CustomersModal from "./CustomersModal.vue";
import ProductsModal from "./ProductsModal.vue";
import ModalResumenFactura from "./ModalResumenFactura.vue";
import TaxesModal from "./TaxesModal.vue";
import FormError from "./FormError.vue";
import Loading from "./Loading.vue";
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
export default {
   props:['currentInvoice','tipoDocumentos','tipoDocumentosNotas','codigoReferencias','medioPagos','condicionVentas','currentTipoDocumento','isCreatingNota','tipoIdentificaciones','tipoDocumentosExo','proforma', 'users','currentUser', 'setting','caja','currency'],
   data () {
       return {
           invoice:{
               TipoDocumento:'04',
               customer_id:0,
               cliente:'',
               email:'',
               CodigoMoneda:'CRC',
               CodigoActividadReceptor:'',
               tipo_identificacion_cliente: '',
               identificacion_cliente: '',
               MedioPago:'01',
               CondicionVenta:'01',
               PlazoCredito:'',
               TotalServGravados: 0,
               TotalServExentos: 0,
               TotalServExonerado:0,
               TotalServNoSujeto: 0,
               TotalMercanciasGravadas: 0,
               TotalMercanciasExentas: 0,
               TotalMercNoSujeta: 0,
               TotalMercExonerada:0,
               TotalGravado: 0,
               TotalExento: 0,
               TotalExonerado: 0,
               TotalNoSujeto:0,
               TotalVenta: 0,
               TotalDescuentos: 0,
               TotalVentaNeta: 0,
               TotalImpuesto: 0,
               TotalIVADevuelto:0,
               TotalComprobante:0,
               TipoCambio:1,
               ValorDolar:0,
               lines:[],
               referencias:[],
               initialPayment:'',
               status:1,
               observations:'',
               pay_with:0,
               change:0,
               created_by: this.currentUser ? this.currentUser.id : 0
           },
           referencia:{
                referencia_id: this.currentInvoice ? this.currentInvoice.id : 0,
                TipoDocumento: '01',
                NumeroDocumento: this.currentInvoice.clave_fe,
                FechaEmision:this.currentInvoice.created_at,
                CodigoReferencia:'',
                Razon:''
            },
           code:'',
           customerDiscount:0,
           cambio:false,
           errors:[],
           loader: false,
           exoall:false,
           showReferencias:false,
           configDateReferencia:{
                dateFormat:'Y-m-d H:m:s'
            },
            proformaid:'',   
            dolar_value:0,
            symbol:"₡",
            isUpdatingCurrency:false,
            lastEnterTime: 0,
            enterTimeout: 300,
       }
   },
   components:{
       CustomersModal,
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
    refreshCSRFToken() {
        return new Promise((resolve, reject) => {
            axios.get('/csrf-token')
                .then(response => {
                    const token = response.data.csrf_token;
                    if (token) {
                        // Actualizar el meta tag
                        const metaTag = document.querySelector('meta[name="csrf-token"]');
                        if (metaTag) {
                            metaTag.setAttribute('content', token);
                        }
                        // Actualizar axios headers
                        axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                        resolve();
                    } else {
                        reject(new Error('Token CSRF no recibido'));
                    }
                })
                .catch(error => {
                    console.error('Error al renovar token CSRF:', error);
                    // Como fallback, intentar obtener el token del meta tag actual
                    const metaTag = document.querySelector('meta[name="csrf-token"]');
                    if (metaTag && metaTag.getAttribute('content')) {
                        const currentToken = metaTag.getAttribute('content');
                        axios.defaults.headers.common['X-CSRF-TOKEN'] = currentToken;
                        resolve(); // Continuar con el token existente
                    } else {
                        reject(error);
                    }
                });
        });
    },
    handleKeydown(event) {
      // Detectar si es un número
      if (event.key >= '0' && event.key <= '9') {
        let payWithInput = document.getElementById('payWith')
        if(payWithInput){
            payWithInput.focus()
        }
      }
    },
    changeCurrency(){
        this.symbol = this.invoice.CodigoMoneda == "CRC" ? "₡" : "$";
        let lines = this.invoice.lines;

        if(lines.length > 0){
            if(this.invoice.CodigoMoneda == "USA"){
                lines.map((item,index)=>{
                    item.PrecioUnitario = item.PrecioUnitario / this.dolar_value
                    this.refreshLine(item,index);
                });
            }else{
                this.invoice.lines = [];
                lines.map((item,index)=>{
                    let product = item.product
                    this.createInvoiceLine(product);
                });
            }
        }
    },
    updateCurrency(){
        axios.put(`/currencies/${this.currency.id}`,{exchange:this.dolar_value})
        .then( response => {
            if(response.status == 204){
                this.isUpdatingCurrency = false;
                flash('Valor actualizado!');
            }
            
        })
        .catch( error => {
            console.log(error);
            flash('Error: Valor no actualizado!','danger');
        })
    },
    updateSeller(){
        if(this.invoice.id){
        axios.put(`/invoices/${this.invoice.id}/updateseller`, this.invoice)
            .then(data => {
                
                flash('Vendedor actualizado Agregado');
                
            });
        }
        
    },
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
    moneyFormat(n,symbol = '₡'){
        
        if(typeof n === "number"){

            return symbol + n.format(2);
        }

        return symbol + n;
    },
    listenCliente(e){
        
        if(!e.target.value){
            this.invoice.customer_id = 0;
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
        let now = Date.now();

        if (now - this.lastEnterTime < this.enterTimeout) {
            this.onDoubleEnter();
            this.lastEnterTime = 0; // reinicia para evitar múltiples disparos
        } else {
            this.lastEnterTime = now;
            axios.get(`/products?code=${this.code}`)
            .then(data => {
                if(data.data){
                    this.addProduct(data.data)
                    let codeProductInput = document.getElementById('codeProduct');
                    codeProductInput.focus();
                
                }else{
                    flash('Producto No encontrado', 'danger');
                }
            })
        }
        
    },
    onDoubleEnter() {
      let submitButton = document.getElementById('submit-button');

      submitButton.click();
      // Aquí va tu lógica
    },
    addCliente(cliente){
        this.invoice.customer_id = cliente.id
        this.invoice.cliente = cliente.name
        this.invoice.email = cliente.email
        this.invoice.tipo_identificacion_cliente = cliente.tipo_identificacion
        this.invoice.identificacion_cliente = cliente.identificacion
        
        let discount = parseFloat(cliente.PorcentajeDescuento)

        this.customerDiscount = discount
        
        
        if(this.invoice.lines.length){
            this.invoice.lines.forEach((line, index) => {
                line.PorcentajeDescuento = this.customerDiscount
                this.refreshLine(line, index)
            });
            
        }
        
    },
    findClienteById(clienteId){
        
        axios.get('/customers/'+ clienteId)
            .then(({data}) =>{
                this.addCliente(data);
            }).catch( error =>{
                console.log('No se encontro el cliente con ese ID');
            });
        
    },
    addProduct(product){
        if(product.taxes.length < 1) {
            console.log('entroo')
            flash('Este producto no tiene configurado los impuestos', 'danger');
        } else if(!product.CodigoProductoHacienda) {
            flash('Este producto no tiene configurado el códgio cabys', 'danger');
        } else {
            
            this.createInvoiceLine(product)
            flash('Producto Agregado');
        }
    },
    cleanInvoiceLines(){
        this.invoice.lines = []
        this.calculateInvoice(this.invoice.lines);
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
            let dolar_amount = this.invoice.CodigoMoneda == "CRC" ? 1 : this.dolar_value;
            let dolarPrice = product.price / dolar_amount;

            let nuevo = {
                CodigoProductoHacienda: product.CodigoProductoHacienda,
                Codigo: product.code,
                Detalle: product.name,
                existencias: product.quantity,
                Cantidad: 1,
                UnidadMedida: product.measure,
                PrecioUnitario: parseFloat(this.invoice.CodigoMoneda == "CRC" ? product.price : dolarPrice).toFixed(3),
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

            this.invoice.lines.unshift(line);
        }

        this.calculateInvoice(this.invoice.lines)
        this.code = '';
    },
    refreshLine(line, index){
        this.updateInvoiceLine(this.calculateInvoiceLine(line, index), index);
        let codeProductInput = document.getElementById('codeProduct');
        codeProductInput.focus();
    },
    updateInvoiceLine(line, index){
        
        this.invoice.lines.splice(index, 1, line);
        this.calculateInvoice(this.invoice.lines)
    },
    allLinesExo(lineInvoice, lineTax, lineInvoiceindex){
        
        this.invoice.lines.forEach((line, index) => {
            
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
        
        if(!this.invoice.id || this.isCreatingNota){
        this.calculateExoneration(line, lineTax, index);
        }
        this.updateInvoiceLine(this.calculateInvoiceLine(line, index), index);
        
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
                        if(line.exo ){
                            
                            let porcenExoProporcion = 100-((parseFloat(tax.tarifa) - parseFloat(tax.PorcentajeExoneracion)) * (100 / parseFloat(tax.tarifa)));
                            
                            TotalMercanciasGravadas += (1 - porcenExoProporcion/100) * line.MontoTotal;
                                
                            TotalMercExonerada += (porcenExoProporcion/100) * line.MontoTotal;

                        }else{
                            TotalMercExonerada += 0;

                            if(tax.CodigoTarifa == "10"){
                                TotalMercanciasExentas += parseFloat(line.MontoTotal);
                            }else{
                                TotalMercanciasGravadas += parseFloat(line.MontoTotal);
                            }
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
                                TotalServExonerado += 0;

                                if(tax.tarifa == 0){
                                    TotalServExentos += parseFloat(line.MontoTotal);
                                }else {
                                    TotalServGravados += parseFloat(line.MontoTotal);
                                }

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
        this.invoice.ValorDolar = this.dolar_value;
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
        if(this.isCreatingNota && this.invoice.TipoDocumento != '01' && !this.invoice.referencias.length)
        {
            Swal({
                title: 'Documento de referencia requerido',
                html: 'Necesitar agregar al menos un documento de referencia para poder crear la nota',
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
        
        // Renovar token CSRF antes de la petición
        this.refreshCSRFToken().then(() => {
            axios.post(`/invoices`, this.invoice)
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
        }).catch(() => {
            this.loader = false;
            flash('Error al renovar la sesión. Por favor recarga la página.', 'danger');
        });
            if(this.proformaid != ''){
                axios.put(`/invoices/${this.proformaid}/updateProforma`, this.proforma).catch(error => {
                    flash('Error al guardar la Proforma!!', 'danger');
                });;
            }

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
                
                return axios.post('/invoices/'+ invoice.id + '/pdf',{ to: email })
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
                            // window.location = '/invoices'
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
            inputValue: '1',
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
                if(this.currentInvoice){
                    window.location = '/invoices'
                }
                

            }


            

        });
    },
    addReferencia(){
          
        if(this.referencia){
            let errorM = {}
            if(!this.referencia.TipoDocumento)
            {
                errorM.TipoDocumento = ['Tipo de documento requerido']
                
                
            }
            if(!this.referencia.NumeroDocumento)
            {
                errorM.NumeroDocumento = ['Numero de documento requerido']
                
                
            }
            if(!this.referencia.FechaEmision)
            {
                errorM.FechaEmision = ['Fecha de emisión requerida']
                
                
            }
            if(!this.referencia.CodigoReferencia)
            {
                errorM.CodigoReferencia = ['Código de referencia requerido']
                
                
            }
            if(!this.referencia.Razon)
            {
                errorM.Razon = ['Razon requerido']
                
                
            }

            this.errors = errorM;

            if(!_.isEmpty(this.errors)){
                return;
            }
            
            let newDocumentoReferencia = {
                TipoDocumento: this.referencia.TipoDocumento,
                NumeroDocumento: this.referencia.NumeroDocumento,
                FechaEmision: this.referencia.FechaEmision,
                CodigoReferencia:this.referencia.CodigoReferencia,
                Razon: this.referencia.Razon,
                referencia_id: this.currentInvoice ? this.currentInvoice.id : 0,
            };

            this.invoice.referencias.push(newDocumentoReferencia);
            this.referencia.CodigoReferencia = '';
            this.referencia.Razon = '';

        }
    },
    removeReferencia(item, index){
        this.invoice.referencias.splice(index, 1);
    },
    clearForm(){

        this.invoice = {
            TipoDocumento:'04',
            customer_id:0,
            cliente:'',
            email:'',
            CodigoMoneda:'CRC',
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
        
        let codeProductInput = document.getElementById('codeProduct');
        codeProductInput.focus();
    },
     
       
   },
   created(){
    console.log(this.setting)
    if(this.currency.exchange){
        this.dolar_value = parseFloat(this.currency.exchange).toFixed(2);
    }

    if(this.currentInvoice){
        this.invoice = this.currentInvoice;
        this.dolar_value = this.currency;
        this.symbol = this.invoice.CodigoMoneda == "CRC" ? '₡' : '$';

        if(this.currentTipoDocumento == '10'){
            this.invoice.CondicionVenta = '11';
        }
        
        if(this.isCreatingNota){
            this.invoice.referencias = [];
        }

        if(this.currentTipoDocumento){
            this.invoice.TipoDocumento = this.currentTipoDocumento
        }

        this.invoice.lines.forEach((line, index) => {
            line.updateStock = (this.invoice.TipoDocumento == '02' || this.invoice.TipoDocumento == '03') ? 1 : 0;

            this.refreshLine(line, index);
        });
        this.calculateInvoice(this.invoice.lines)
        
    }else if(this.proforma){
        this.invoice = this.proforma;
        this.invoice.referencias = [];
        this.invoice.status = 1;
        delete this.invoice.id
        delete this.invoice.created_at
        delete this.invoice.updated_at

        this.invoice.lines.forEach((line, index) => {
            line.updateStock = 0;
            delete line.id
            this.proformaid = line.proforma_id;
            delete line.created_at
            delete line.updated_at

            axios.get(`/products?code=${line.Codigo}`)
            .then(data => {
                if(data.data){
                    line.existencias = data.data.quantity
                    
                }

                    this.refreshLine(line, index);

            }).catch(function (error) {

                this.refreshLine(line, index);

            });

            this.refreshLine(line, index);
        });
        
        if(this.proforma.customer_id){
            this.findClienteById(this.proforma.customer_id);
        }

        this.calculateInvoice(this.invoice.lines)
    }
   }

}
</script>
