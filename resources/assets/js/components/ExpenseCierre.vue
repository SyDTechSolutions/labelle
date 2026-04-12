<template>
    <div>
        <div class="form-row">      
                                   
            <!-- <div class="form-group col-md-4">
                <label for="referencia">Observaciones</label>
                <input type="text" class="form-control" name="observations" v-model="expense.observations" >
                <form-error v-if="errors.observations" :errors="errors" style="float:right;">
                    {{ errors.observations[0] }}
                </form-error>
            </div> -->
            <div class="form-group col-md-12" v-if="!show">
                <label for="amount">Gastos</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-secondary" @click="save()">Guardar</button>
                    </div> 
                    
                <input type="text" class="form-control" name="amount" v-model="expense.amount">
                 </div> 
                <form-error v-if="errors.amount" :errors="errors" style="float:right;" >
                    {{ errors.amount[0] }}
                </form-error>
            </div>
            <div v-else class="form-group col-md-12">
                Gastos: {{ moneyFormat(expense.amount) }}
            </div>
          
        </div>
        <div class="form-row">
              <div class="form-group col-md-12">
                
                 <b>Total:</b> {{ totalFinal }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
     props:['totalCierre', 'currentDate','show'],
     data () {
       return {
           expense:{
               date: this.currentDate ? this.currentDate : moment().format('YYYY-MM-DD'),
               MedioPago:'01',
               referencia:'',
               amount: 0,
               observations:'Gastos del dia ' + moment().format('YYYY-MM-DD'),
               fromCierre:1
           },
           date:this.currentDate ? this.currentDate : moment().format('YYYY-MM-DD'),
           errors:[],
           loader: false,
           
           
       }
   },
   computed:{
       totalFinal(){
           return this.moneyFormat(this.totalCierre - this.expense.amount);
       }
   },
   methods:{
       moneyFormat(n){
         
           if(typeof n === "number"){

                return '₡' + n.format(2);
           }

           return '₡' + n;
       },
      save(){
            
           this.persist();
           
       },
       persist(){
            if(this.loader) {
               return;
           }

           this.loader = true;
            if(this.expense.id){

                axios.put(`/expenses/${this.expense.id}`, this.expense)
                    .then(({data}) => {
                        this.loader = false;
                        //this.clearForm();
                        flash('Gasto Guardado Correctamente.');
                        this.$emit('updated', data);
                        this.expense = data;
                            


                    })
                    .catch(error => {
                        this.loader = false;
                        flash('Error al guardar el Gasto!!', 'danger');
                    });

           }else{

                axios.post(`/expenses`, this.expense)
                .then(({data}) => {
                    this.loader = false;

                    flash('Gasto Guardado Correctamente.');
                    this.$emit('created', data);
                     this.expense = data;

                   


                })
                .catch(error => {
                    this.loader = false;
                    flash('Error al guardar el Gasto!!', 'danger');
                });

           }
       },
       fetch(){
                axios.get(`/expenses/last?date=${this.date}&fromCierre=1`)
                .then(this.refresh)
            },

            refresh({data}){
                if(data){
                    this.expense = data
                }
            },
   },
   created(){
       this.fetch();
   }
}
</script>
