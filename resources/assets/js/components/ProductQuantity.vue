<template>
    <div class="w-full d-flex flex-column">
        <div v-if="!updatingQuantity" class="d-flex">
            <span>{{ quantity }}</span>
            <button 
            type="button" 
            class="border-0 d-flex align-items-center" 
            style="background-color: white;"
            @click="handleUpdate()">
                <svg id="edit" v-if="!updatingQuantity" style="width: 18px; height: 20px; margin-top: 2px; margin-left: 5px; color: rgba(0, 0, 0, 0.651);" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
                    <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
                </svg>
            </button>
        </div>
        <div class="d-flex flex-column" v-if="updatingQuantity">
            <input 
            type="number" 
            class="form-control" 
            v-model="quantity"
            style="width: 100px;" 
            @keypress.prevent.enter="submitUpdate()">
            <button 
            type="button" 
            class="text-sm"
            style="width: 100px;" 
            @click="handleUpdate()">
                Cancelar
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props:['product'],
        data(){
            return {
                quantity:0,
                product_id:0,
                updatingQuantity:false
            }
        },
        methods:{
            handleUpdate(){
                this.updatingQuantity = !this.updatingQuantity
            },
            submitUpdate(){
                axios.put(`/products/${this.product_id}/quantity`, {
                    quantity: this.quantity
                })
                .then(response => {
                    console.log(response)
                    flash('La existencia se ha actualizado!');
                    this.handleUpdate()
                })
                .catch(error => {
                    console.error(error.response.data);
                    flash('Las existencias no se ha podido actualizar!','danger');
                });
            }
        },
        mounted(){
            this.quantity = this.product.quantity
            this.product_id = this.product.id
        }
    }
</script>

<style lang="scss" scoped>

</style>