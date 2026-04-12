<script>
export default {
  props:['product','taxes','checkedTaxes'],

  data(){
        return {
          cost: this.product ? this.product.purchase_price : 0,
          utilidad:this.product ? this.product.utilidad : 0,
          price: this.product ? this.product.price : 0,
          priceWithTaxes: this.product ? this.product.priceWithTaxes : 0,
          selectedTaxes: this.checkedTaxes ? this.checkedTaxes : [],
          showBuscadorCabys: false,
          searchCabys:'',
          cabysProducts:[],
          loading:false,
          CodigoProductoHacienda:this.product ? this.product.CodigoProductoHacienda : '',
          noResults:false,
          photo_preview:[]
        }
  },
  watch:{
    'photo_preview': {
        handler(value){
            if(value.length > 0){
                this.loadPreviews()
            }
        }
    }
  },
  methods:{
        handleFileUpload(event) {
            let files = event.target.files;
            if (files.length == 1) {
                let filesArray = Array.from(files); // Convertimos a un array
                this.photo_preview = []; // Reiniciamos las previews
                filesArray.forEach((file) => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.photo_preview.push(e.target.result); // Agregamos la URL de la imagen
                    };
                    reader.readAsDataURL(file);
                    // this.loadPreviews()
                } else {
                    alert("Solo se permiten archivos de imagen.");
                }
                });
            }
        },
        loadPreviews(){
            let preview_div = document.getElementById("photos_previews")
            let html = "";
            this.photo_preview.forEach(photo => {
                html = `<img src="${photo}" alt="preview" style="height:350px;" class="img-thumbnail">`
            })
            preview_div.innerHTML = html
        },
        seleccionarCodigoCabys(item){
            this.CodigoProductoHacienda = item.codigo; 
            this.showBuscadorCabys = false; 
            this.cabysProducts = []; 
            this.searchCabys = '';
                
                let tax = _.find(this.taxes, { 'tarifa': parseFloat(item.impuesto) });
                
                if(tax){
                    this.selectedTaxes = [];
                    this.selectedTaxes.push(tax.id);
                }
            
        },
        searchCodigoCabys(){
            if(this.loading){
                return;
            }
            if(!this.searchCabys){
                return;
            }
            this.loading = true;
            this.noResults = false;

                let isCode = /^\d+$/.test(this.searchCabys);

                let queryParam = isCode ? 'codigo' : 'q';

            axios.get('https://api.hacienda.go.cr/fe/cabys?'+ queryParam + '=' + this.searchCabys)
            .then( ({ data }) =>{

                this.loading = false;
                this.cabysProducts = queryParam == 'codigo' ? data : data.cabys;
                this.noResults = !this.cabysProducts.length ? true : false;
            })
        },
        calculatePrice(){
            let price = 0;
            let cost = parseFloat(this.cost);
            let utilidad = parseFloat(this.utilidad)
            let taxAmount = 0;

            this.selectedTaxes.forEach(taxId => {
                
                    let tax = _.find(this.taxes, { 'id': parseInt(taxId) });
                    
                    if(tax){
                        
                        taxAmount += cost * (parseFloat(tax.tarifa) / 100)
                    }
            });
            
            this.price = redondeo((cost * (utilidad) / 100) + cost);

            cost += taxAmount;

            this.priceWithTaxes =redondeo((cost * (utilidad) / 100) + cost);


        },
        calculateFromPriceWithTaxes() {
            let cost = parseFloat(this.cost);
            let priceWithTaxes = parseFloat(this.priceWithTaxes);
            let totalTaxRate = 0;

            this.selectedTaxes.forEach(taxId => {
                let tax = _.find(this.taxes, { 'id': parseInt(taxId) });
                if (tax) {
                    totalTaxRate += parseFloat(tax.tarifa);
                }
            });

            let priceWithoutTaxes = priceWithTaxes/(1+(totalTaxRate/100)); 

            if(this.cost > 0) {
                let utilityAmount = priceWithoutTaxes - cost;
                let utility = (utilityAmount/cost) * 100
    
                this.utilidad = redondeo(utility);
            }

            if(this.cost == 0){
                this.cost = redondeo(priceWithoutTaxes);
                cost = this.cost;
            }

            this.price = redondeo(cost + (cost * this.utilidad / 100));
        }
  }
}
</script>
