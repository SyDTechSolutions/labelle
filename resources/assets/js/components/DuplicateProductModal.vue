<template>
    <div>
        <button type="button" class="btn btn-info btn-sm" @click="openModal()">
            Duplicar
        </button>

        <div v-if="showModal" class="modal fade show d-block" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Duplicar Producto</h5>
                        <button type="button" class="close" @click="closeModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dup-code">Código*</label>
                            <input type="text" class="form-control" id="dup-code" v-model="form.code">
                            <span class="text-xs text-muted">El código debe ser diferente al original</span>
                        </div>
                        <div class="form-group">
                            <label for="dup-name">Nombre*</label>
                            <input type="text" class="form-control" id="dup-name" v-model="form.name">
                        </div>
                        <div class="form-group">
                            <label for="dup-quantity">Existencias*</label>
                            <input type="number" class="form-control" id="dup-quantity" v-model="form.quantity" step="any">
                        </div>
                        <div class="form-group">
                            <label for="dup-price">Precio sin I.V*</label>
                            <input type="text" class="form-control" id="dup-price" v-model="form.price">
                        </div>
                        <div v-if="error" class="alert alert-danger mt-2">{{ error }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="duplicate()" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                            Duplicar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        product: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            showModal: false,
            loading: false,
            error: null,
            form: {
                code: '',
                name: '',
                quantity: 0,
                price: 0
            }
        }
    },
    methods: {
        openModal() {
            this.form.code = this.product.code;
            this.form.name = this.product.name;
            this.form.quantity = this.product.quantity;
            this.form.price = this.product.price;
            this.error = null;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.error = null;
        },
        duplicate() {
            this.loading = true;
            this.error = null;

            axios.post(`/products/${this.product.id}/duplicate`, {
                code: this.form.code,
                name: this.form.name,
                quantity: this.form.quantity,
                price: this.form.price
            })
            .then(response => {
                flash('Producto duplicado exitosamente');
                this.closeModal();
                window.location.reload();
            })
            .catch(error => {
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    this.error = Object.values(errors).flat().join(', ');
                } else {
                    this.error = 'Error al duplicar el producto';
                }
            })
            .finally(() => {
                this.loading = false;
            });
        }
    }
}
</script>
