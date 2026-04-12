<template>
    <div class="invoice-form">
        <loading :show="loader"></loading> 

        <form @submit.prevent="save()">
            <div class="row justify-content-between">
            
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Gastos</div>

                            <div class="card-body">
                                <div class="form-row">
                                     <div class="form-group col-md-6">
                                        <label for="fecha_factura">Fecha</label>
                                       
                                        <flat-pickr
                                                v-model="expense.date"                                             
                                                class="form-control" 
                                                placeholder="Select date"               
                                                name="date">
                                        </flat-pickr>
                                    </div>
                                
                                    <div class="form-group col-md-6">
                                        <label for="MedioPago">Medio Pago</label>
                                        <select class="form-control custom-select" name="MedioPago" id="MedioPago" v-model="expense.MedioPago" >
                                    
                                        <option v-for="(value, key, index) in medioPagos" :value="key" :key="index">
                                            {{ value }}
                                        </option>
                                        
                                        </select>
                                    </div>
                                
                                </div>
                                <div class="form-row">
                                    
                                    
                                   
                                    <div class="form-group col-md-4">
                                        <label for="referencia">Referencia</label>
                                        <input type="text" class="form-control" name="referencia" v-model="expense.referencia" >
                                        <form-error v-if="errors.referencia" :errors="errors" style="float:right;">
                                            {{ errors.referencia[0] }}
                                        </form-error>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="amount">Monto</label>
                                        <input type="text" class="form-control" name="amount" v-model="expense.amount">
                                         <form-error v-if="errors.amount" :errors="errors" style="float:right;">
                                            {{ errors.amount[0] }}
                                        </form-error>
                                    </div>
                                </div>
                                <div class="form-row">
                                   
                                
                                    <div class="form-group col-md-12">
                                        <label for="observations">Observaciones</label>
                                         <textarea name="observations" class="form-control" v-model="expense.observations" cols="30" rows="1" ></textarea>
                                       
                                            
                                        <form-error v-if="errors.observations" :errors="errors" style="float:right;">
                                            {{ errors.observations[0] }}
                                        </form-error>
                                    </div>
                                    
                                
                                </div>
                                
                            </div>
                        </div>
                       

                         <div class="form-group">
                            <button type="submit" class="btn btn-success">Guardar</button>
                           
                        
                            <a href="/expenses" class="btn btn-light" role="button">Regresar</a>
                        </div>
                    </div>  <!--col-->
                   


          
            </div>

        </form>



    </div>
    
</template>
<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import FormError from "./FormError.vue";
import Loading from "./Loading.vue";
export default {
   props:['currentExpense','medioPagos'],
   data () {
       return {
           expense:{
               date:'',
               MedioPago:'01',
               referencia:'',
               amount: 0,
               observations:''
           },
           errors:[],
           loader: false,
           
           
       }
   },
   components:{
       flatPickr,
       FormError,
       Loading
   },
   
   methods:{
       disableFields(){
           
           return (this.expense.id)
       },
      
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
                            


                    })
                    .catch(error => {
                        this.loader = false;
                        flash('Error al guardar el Gasto!!', 'danger');
                    });

           }else{

                axios.post(`/expenses`, this.expense)
                .then(({data}) => {
                    this.loader = false;

                    this.clearForm();
                    flash('Gasto Guardado Correctamente.');
                    this.$emit('created', data);

                   


                })
                .catch(error => {
                    this.loader = false;
                    flash('Error al guardar el Gasto!!', 'danger');
                });

           }
       },
       
       
       clearForm(){

           this.expense = {
               date:'',
               MedioPago:'01',
               referencia:'',
               amount: 0,
               observations:''
           };
            

       }
       
   },
   created(){
       if(this.currentExpense){
           this.expense = this.currentExpense;
       }
   }

}
</script>
