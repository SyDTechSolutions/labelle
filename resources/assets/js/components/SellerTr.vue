<template>
     <tr>
                                        
            <th scope="row">{{ seller.name }}</th>
            <td>{{ seller.invoices_count }}</td>
            <td>{{ moneyFormat(invoices_total) }}</td>
            
            <td>
               <input
                    class="form-control form-control-sm"
                    type="text" 
                    v-model="commission"
                    @blur="calculateCommission()"
                    @keydown.enter.prevent="calculateCommission()"/>
               
            </td>
            <td>{{ moneyFormat(commission_total)  }}</td>
        
        
    </tr>
     
</template>
<script>
export default {
  props:['seller'],
  name: 'seller-tr',
  data(){
      return {
          commission:  this.seller ? parseFloat(this.seller.commission) : 0,
          commission_total: this.seller ? parseFloat(this.seller.commission_total) :0,
          invoices_total: this.seller ? parseFloat(this.seller.invoices_total) :0,
      }
  },
  methods:{
       moneyFormat(n){
         
           if(typeof n === "number"){

                return '₡' + n.format(2);
           }

           return '₡' + n;
       },
      calculateCommission(){
          let totalComision = 0;
          let commission = parseFloat(this.commission);
          let totalFacturas = parseFloat(this.invoices_total)
         

          
           this.commission_total = redondeo( (totalFacturas * (commission) / 100) );



      }
  },
  created(){
     
      
  }
}
</script>
