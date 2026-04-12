@extends('layouts.app')
@section('header')
<script src="/js/JsBarcode.all.min.js"></script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Inventario </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/products" method="GET">
                                <div class="row">
                                    <div class="col-sm-3" style="display: flex; gap:10px; align-items: end;">
                                        <div>
                                            <label>Buscar: </label>
                                            <input type="search" class="form-control input-sm" placeholder="" name="q" value="{{ $search['q'] }}">
                                        </div>
                                        <div>
                                            <select class="form-control custom-select" name="precision" id="precision">
                                                <option value="preciso" {{ isset($search['precision']) && $search['precision'] == 'preciso' ? 'selected' : ''}}>Preciso</option>
                                                <option value="coincidencias" {{ isset($search['precision']) && $search['precision'] == 'coincidencias' ? 'selected' : ''}}>Coincidencias</option>                                        
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    
                                    </div>
                                </div>
                            </form>
                           
                    </div>
                    <div class="buttons level mt-2">
                      <div class="flex">

                          <a href="/products/create" class="btn btn-success btn-sm">Crear Producto</a>
                      </div>
                     <form class='mr-2' action="/products/export" method="POST">
                            @csrf
                             <div class="form-row">
                                <div class="form-check mb-2 mr-2">
                                    <input class="form-check-input" name="filter" type="radio" id="todos" value="0" checked>
                                    <label class="form-check-label" for="todos">
                                        Todos
                                    </label>
                                </div>
                                <div class="form-check mb-2 mr-2">
                                    <input class="form-check-input" name="filter" type="radio" id="minimos" value="1">
                                    <label class="form-check-label" for="minimos">
                                        Minimos <span class="square square-red"></span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-secondary btn-sm">Exportar</button>
                             </div>
                             
                          
                            <div class="form-row">
                                
                            </div>
                    </form>
                    <form action="/products/import"  method="POST" enctype="multipart/form-data">
                        @csrf
                         <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload">Importar</a>

                         <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Subir Archivo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="form-group">
                                            <label for="archivo">Archivo excel o csv</label>
                                            <input type="file" name='archivo' class="form-control-file">
                                            <button type="submit" class="btn btn-primary my-2">Subir</button>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </div>
                            </div>
                          </div>
                        </form>
                    
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Existencias</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Medida</th>
                                    <th scope="col">Codigo barras 
                                        <input type="checkbox" name="select_all_barcodes" id="select_all_barcodes"/> 
                                        
                                        <a href="#" class="btn btn-secondary d-none" data-target="#printBarcodesLote">Imprimir</a>
                                       
                                    </th>
                                    
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                            
                                <tr class="{{ ($product->quantity <= $product->min) ? 'table-danger': '' }}">
                                    <th scope="row">{{ $product->id }}</th>
                                    <td><a href="/products/{{ $product->id }}/edit">{{ $product->code }}</a></td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <product-quantity :product="{{ json_encode(isset($product) ? $product : '')  }}"></product-quantity>
                                    </td>
                                    <td>{{ money($product->priceWithTaxes) }}</td>
                                    <td>{{ $product->measure }}</td>
                                    <td>
                                        <svg id="barcode{{ $product->id }}"></svg>
                                        <script>

                                            JsBarcode("#barcode{{ $product->id }}", "{{ $product->code }}",{
                                                format:"CODE128",
                                                lineColor: "#000",
                                                width: 2,
                                                height: 40,
                                                displayValue: true
                                            });
                                        
                                        
                                        </script>
                                        <br>
                                        <a href="#" class="btn btn-secondary"
                                        onclick="window.open('/products/{{ $product->id }}/barcodes/print','name','width=900,height=500')">
                                            Imprimir
                                        </a>
                                        
                                        <input id="chk-barcode{{ $product->id }}" type="checkbox" name="barcodes[]" value="{{ $product->id }}" class="chk-item">
                                          
                                        
                                    </td>

                                    <td>
                                        <duplicate-product-modal :product="{{ json_encode($product) }}"></duplicate-product-modal>

                                        @can('update', $product)
                                        <form method="POST" action="{{ url('products/'. $product->id) }}" data-confirm="Estas Seguro?">
                                            @csrf
                                            {{ method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                                Eliminar
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                               @endforeach
                                   @if ($products)
                                    <td  colspan="8" class="pagination-container">{!!$products->appends(['q' => $search['q']])->render()!!}</td>
                                @endif
                            
                            </tbody>
                        </table>
                        <div>
                         <h5><b>Valor Inventario:</b> {{  money($valorInventario) }}</h5>
                         <h5><b>Costo Inventario:</b> {{  money($costoInventario) }}</h5>
                        </div>

                   </div>
                </div>
            </div>
        </div>
        <div id="imageModal" 
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
            <span onclick="closeModal()" 
                style="position: absolute; top: 20px; right: 30px; color: white; font-size: 30px; cursor: pointer;">&times;</span>
            <img id="modalImage" 
                style="max-width: 90%; max-height: 90%; border-radius: 10px;">
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var chkItem = $('.chk-item'),
      chkSelectAll = $('#select_all_barcodes')
      productsIds = [];

    

   $('a[data-target="#printBarcodesLote"]').on('click', function (e) {

       
       if(!verificaChkActivo(chkItem))
       {
           alert('Seleccione al menos un item de la lista');
           return;

       }

       console.log(productsIds);
       window.open('/products/barcodes/print?barcodes='+ productsIds.toString(),'name','width=900,height=500')

       
   });
   

      chkSelectAll.on('click', function (e) {
 
         var c = this.checked;
        $(':checkbox').prop('checked',c);
        $('a[data-target="#printBarcodesLote"]').toggleClass('d-none');
      });

      chkItem.on('click', function (e) {
 
        if(verificaChkActivo(chkItem)){
            $('a[data-target="#printBarcodesLote"]').removeClass('d-none');
        }else{
            $('a[data-target="#printBarcodesLote"]').addClass('d-none');
        }
           
    });

    function verificaChkActivo(chks) {
        var state = false;
        productsIds = [];
        chks.each(function(){

            if(this.checked)
            {

                state = true;
                productsIds.push(this.value);


            }

        });

        return state;
    }

    function showImage(src) {
        let modal = document.getElementById('imageModal');
        let modalImage = document.getElementById('modalImage');
        modalImage.src = src;
        modal.style.display = 'flex'; // Muestra el modal
    }

    function closeModal() {
        let modal = document.getElementById('imageModal');
        modal.style.display = 'none'; // Oculta el modal
    }
  
</script>
@endsection
