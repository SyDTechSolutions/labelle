<script src="/js/JsBarcode.all.min.js"></script>
<style>
    * {
     font-size: 12px;
     font-family: 'Times New Roman';
   }
    
    .ticket {
    /*margin-left: 6rem;*/
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-content: center;
    align-items: center;
    
    /* width: 110px
    max-width: 110px; */
    }
    
    img {
    max-width: inherit;
    width: inherit;
    }
    @media print{
        .oculto-impresion, .oculto-impresion *{
            display: none !important;
        }
    }
    </style>
   
        @foreach ($products as $product)
            <div class="ticket" >
                <div>
                    <svg id="barcode{{ $product->id }}" ></svg>
                    <script>
        
                        JsBarcode("#barcode{{ $product->id }}", "{{ $product->code }}",{
                            format:"CODE128",
                            lineColor: "#000",
                            width: 1,
                            height: 20,
                            displayValue: true
                        });
                    
                    
                    </script>
                </div>
                
            
        </div>
        @endforeach
      
       
       

       
   <a class="oculto-impresion" href="/products">Regresar</a>
   
   <script>
       function printSummary() {
               window.print();
           }
           
           window.onload = printSummary;
   </script>
   