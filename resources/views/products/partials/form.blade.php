<product-view :product="{{ json_encode(isset($product) ? $product : false) }}" :taxes="{{ $taxes }}" :checked-taxes="{{ json_encode(isset($product) ? $product->taxes->pluck('id') : []) }}" inline-template>
<div class="row justify-content-between">
<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-primary text-white">Informacion básica</div>

        <div class="card-body">
            <p><small>(*) Campos requeridos</small></p>
             <div class="form-group">
            
                    <label for="type">Tipo</label>
                    <select class="form-control custom-select {{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="type" >
                        
                      
                            <option value="P" {{ isset($product) && $product->type == 'P' ? 'selected' : (old('type') == 'P' ? 'selected' : '')  }}>Producto / Mercancia</option>
                            <option value="S" {{ isset($product) && $product->type == 'S' ? 'selected' : (old('type') == 'S' ? 'selected' : '')  }}>Servicio</option>
                       
                    </select>
                        
                    @if ($errors->has('type'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('type') }}</strong>
                        </div>
                    @endif
                        
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="CodigoProductoHacienda">Código CABYS*</label>
                    <div class="input-group">
            
                        
                        <input type="text" class="form-control {{ $errors->has('CodigoProductoHacienda') ? ' is-invalid' : '' }}" id="CodigoProductoHacienda" name="CodigoProductoHacienda" placeholder="" v-model="CodigoProductoHacienda" value="{{ isset($product) ? $product->CodigoProductoHacienda : old('CodigoProductoHacienda') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" 
                            type="button"
                            @click="showBuscadorCabys = !showBuscadorCabys"><svg v-show="!showBuscadorCabys" class="w-6 h-6" style="width:16px; height:16px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            <svg v-show="showBuscadorCabys" class="w-6 h-6" style="width:16px; height:16px;" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                           </button>
                        </div>
                        
                    </div>
                    
                    @if ($errors->has('CodigoProductoHacienda'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('CodigoProductoHacienda') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="card bg-light  mb-4 w-100" v-show="showBuscadorCabys" >
                    <div class="card-body">
                        <input type="text" class="form-control" name="q" id="inputCabys" placeholder="Buscar..." v-model="searchCabys" @keyup.enter="searchCodigoCabys">
                        
                            <div v-show="loading" class="spinner-border text-primary mt-3" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                      
                        <div style="max-height: 300px; overflow-y:scroll" class="mt-3" v-show="!loading">
                            <ul class="list-group ">
                                <li class="list-group-item d-flex justify-content-between align-items-center" v-for="item in cabysProducts" :key="item.codigo">
                                    <div>
                                        <div class="font-weight-bold" @click="seleccionarCodigoCabys(item);">
                                            @{{ item.codigo }}
                                        </div>
    
                                        <div class="text-muted">
                                            @{{ item.descripcion }}
                                        </div>
                                        <div class="badge badge-warning">
                                            Impuesto: %@{{ item.impuesto }}
                                        </div>
                                    </div>
                                   
                                  <button type="button" class="btn btn-sm btn-primary" @click="seleccionarCodigoCabys(item);">Seleccionar</button>
                                </li>
                                
                              </ul>
                              <div v-if="noResults">No hay artículos</div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-dark" @click="showBuscadorCabys = false;">Cerrar</button>
                    </div>
                  </div>
               
                
              
            </div>
            
            <div class="form-group">
                <label for="name">Código*</label>
                <input type="text" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" id="code" name="code" placeholder="" value="{{ isset($product) ? $product->code : old('code') }}">
                @if ($errors->has('code'))
                    <div class="error invalid-feedback">
                        <strong>{{ $errors->first('code') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="name">Nombre*</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="" value="{{ isset($product) ? $product->name : old('name') }}">
                @if ($errors->has('name'))
                    <div class="error invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group">
            
                    <label for="measure">Medida*</label>
                    <select class="form-control custom-select {{ $errors->has('measure') ? ' is-invalid' : '' }}" name="measure" id="measure" >
                        
                        @foreach($measures as $measure)    
                            <option value="{{ $measure }}" {{ isset($product) && $product->measure == $measure ? 'selected' : (old('measure') == $measure ? 'selected' : '')  }}>{{ $measure }}</option>
                        @endforeach
                    </select>
                        
                    @if ($errors->has('measure'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('measure') }}</strong>
                        </div>
                    @endif
                        
            </div>

           

            <div class="form-row">
                <div class="form-group col-6">
                    <label for="min">Min</label>
                    <input type="number" class="form-control {{ $errors->has('min') ? ' is-invalid' : '' }}" id="min" name="min" placeholder="" value="{{ isset($product) ? $product->min : old('min') }}" min="0">
                    @if ($errors->has('min'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('min') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group col-6">
                    <label for="quantity">Existencias*</label>
                    <input type="number" class="form-control {{ $errors->has('quantity') ? ' is-invalid' : '' }}" id="quantity" name="quantity" step="any" placeholder="" value="{{ isset($product) ? $product->quantity : old('quantity') }}">
                    @if ($errors->has('quantity'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('quantity') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="purchase_price">Costo</label>
                    <input type="text"
                           class="form-control {{ $errors->has('purchase_price') ? ' is-invalid' : '' }}" id="purchase_price"
                           name="purchase_price" 
                           placeholder="" 
                           v-model="cost"
                           @blur="calculatePrice()"
                           @keydown.enter.prevent="calculatePrice()"
                           >
                    @if ($errors->has('purchase_price'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('purchase_price') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="utilidad">% Utilidad</label>
                    <input type="text"
                           class="form-control {{ $errors->has('utilidad') ? ' is-invalid' : '' }}" id="utilidad" 
                           name="utilidad" 
                           placeholder="" 
                           value="{{ isset($product) ? $product->utilidad : old('utilidad') }}"  v-model="utilidad" 
                           @blur="calculatePrice()"
                           @keydown.enter.prevent="calculatePrice()"
                                                       >
                    @if ($errors->has('utilidad'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('utilidad') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
            
                    <label for="price">Precio sin I.V*</label>
                    <input type="text" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" name="price" placeholder="" value="{{ isset($product) ? $product->price : old('price') }}"
                    v-model="price" 
                    >
                    @if ($errors->has('price'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('price') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="form-group col-md-6">
            
                    <label for="price">Precio con I.V*</label>
                    <input 
                    type="text" 
                    class="form-control" 
                    placeholder=""
                    v-model="priceWithTaxes" 
                    @keydown.enter.prevent="calculateFromPriceWithTaxes()"
                    >
                    
                </div>
            </div>
             
            <div class="form-group">
                <label for="taxes">Impuestos</label>
                 @foreach($taxes as $tax)    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $tax->id }}" id="tax-{{ $tax->id }}" name="taxes[]" {{ isset($product) && $product->hasTax($tax->code) ? 'checked' : '' }} v-model="selectedTaxes"  @change="calculatePrice()">
                        <label class="form-check-label" for="tax-{{ $tax->id }}">
                            {{ $tax->name }} ({{ percent($tax->tarifa) }})
                        </label>
                    </div>
                @endforeach
                
            </div>
            <div class="form-group">
             @if(isset($product))
                @can('update', $product)
                    <button type="submit" class="btn btn-primary">Guardar</button>
                @endcan
            @else 
                <button type="submit" class="btn btn-primary">Guardar</button>
            @endif
            <a href="/products" class="btn btn-default"> Regresar</a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-primary text-white">Informacion adicional</div>

        <div class="card-body">
            
            <div class="form-group">
                <label for="location">Ubicación</label>
                <input type="text" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" id="location" name="location" placeholder="" value="{{ isset($product) ? $product->location : old('location') }}">
                @if ($errors->has('location'))
                    <div class="error invalid-feedback">
                        <strong>{{ $errors->first('location') }}</strong>
                    </div>
                @endif
            </div>


            <div class="form-group">
            
                    <label for="provider_id">Proveedor</label>
                    <select class="form-control custom-select {{ $errors->has('provider_id') ? ' is-invalid' : '' }}" name="provider_id" id="provider_id" >
                            <option value="">-- Selecciona un proveedor --</option>
                        @foreach($providers as $provider)    
                            <option value="{{ $provider->id }}" {{ isset($product) && $product->provider_id == $provider->id ? 'selected' : (old('provider_id') == $provider->id ? 'selected' : '')  }}>{{ $provider->name }}</option>
                        @endforeach
                    </select>
                        
                    @if ($errors->has('provider_id'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('provider_id') }}</strong>
                        </div>
                    @endif
                        
            </div>
            
            
                <div class="form-group">
                <label for="subquantity">Cant / Paq</label>
                <input type="number" class="form-control {{ $errors->has('subquantity') ? ' is-invalid' : '' }}" id="subquantity" name="subquantity" placeholder="" value="{{ isset($product) ? $product->subquantity : old('subquantity','1') }}" min="1" >
                @if ($errors->has('subquantity'))
                    <div class="error invalid-feedback">
                        <strong>{{ $errors->first('subquantity') }}</strong>
                    </div>
                @endif
            </div>
          
            
            <div class="form-group">
                <label for="observations">Observaciones</label>
                <textarea name="observations" id="observations" cols="30" rows="2" class="form-control {{ $errors->has('observations') ? ' is-invalid' : '' }}">
                    {{ isset($product) ? $product->observations : old('observations') }}
                </textarea>
                
                @if ($errors->has('observations'))
                    <div class="error invalid-feedback">
                        <strong>{{ $errors->first('observations') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input 
                    type="file" 
                    class="custom-file-input {{ $errors->has('photo') ? ' is-invalid' : '' }}" 
                    @change="handleFileUpload"
                    accept="image/png, image/jpeg, image/png"
                    id="photo" 
                    name="photo">
                    <label class="custom-file-label {{ $errors->has('photo') ? ' is-invalid' : '' }}" for="photo">Escoge una Foto</label>
                    @if ($errors->has('photo'))
                        <div class="error invalid-feedback">
                            <strong>{{ $errors->first('photo') }}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group" id="photos_previews">
                
            </div>
            @if(isset($product) && $product->photo_path) 
                <div class="form-group">
                    <img src="{{ $product->photo() }}" alt="{{ $product->name }}" class="img-thumbnail">
                </div>
        
            @endif
            @if(isset($product)) 
            <div class="form-group">
                <svg id="barcode{{ $product->id }}"></svg>
                <a href="#" class="btn btn-secondary"
                onclick="window.open('/products/{{ $product->id }}/barcodes/print','name','width=900,height=500')">
                    Imprimir
                </a>
            </div>
            @endif
            
        </div>
    </div>
</div>
</div>
</product-view>
  
  
