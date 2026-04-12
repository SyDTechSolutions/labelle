<script>
export default {
  props:['tax','codesTaxes','codesTarifaIva'],

  data(){
      return {
          tarifa: this.tax ? this.tax.tarifa : 0,
          CodigoTarifa: this.tax ? this.tax.CodigoTarifa : '08',
      }
  },
  methods:{
      onChangeCodigoTarifa(){
          
        let ct = _.find(this.codesTarifaIva, { 'code': this.CodigoTarifa });
         
         this.tarifa = ct.value;
         

      }
  },
  created(){
      if(!this.tax){
          this.onChangeCodigoTarifa();
      }
      
  }
}
</script>
