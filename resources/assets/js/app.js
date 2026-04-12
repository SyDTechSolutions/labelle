
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');
window.Swal = require('sweetalert2')
window.flatpickr = require("flatpickr");
window.events = new Vue();

window.provincias = require('./ubicaciones');

window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Number.prototype.format = function (n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));

    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

window.roundM = function (num, multiple = 1) {
    return Math.ceil(num/multiple)*multiple;
};

window.redondeo = function(numero, decimales = 2)
{
var flotante = parseFloat(numero);
var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);
return resultado;
}

window.moneyFormat = function(n, symbol = '₡'){

    if (typeof n === "number") {

        return symbol + n.format(2);
    }

    return symbol + n;
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue').default);

Vue.component('invoice-form', require('./components/InvoiceForm.vue').default);
Vue.component('proforma-form', require('./components/ProformaForm.vue').default);
Vue.component('purchase-form', require('./components/PurchaseForm.vue').default);
Vue.component('payments-modal', require('./components/PaymentsModal.vue').default);
Vue.component('cxc-modal', require('./components/CxcModal.vue').default);
Vue.component('cxp-modal', require('./components/CxPModal.vue').default);
Vue.component('purchase-payments-modal', require('./components/PurchasePaymentsModal.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('caja-modal', require('./components/CajaModal.vue').default);

Vue.component('modal-status-hacienda', require('./components/ModalStatusHacienda.vue').default);
Vue.component('send-to-hacienda', require('./components/SendToHacienda.vue').default);
Vue.component('mensaje-receptor', require('./components/MensajeReceptor.vue').default);
Vue.component('send-mensaje-to-hacienda', require('./components/SendMensajeToHacienda.vue').default);
Vue.component('send-to-hacienda-compra', require('./components/SendToHaciendaCompra.vue').default)
Vue.component('modal-status-mensaje-hacienda', require('./components/ModalStatusMensajeHacienda.vue').default);

Vue.component('product-view', require('./pages/Product.vue').default);

Vue.component('expense-form', require('./components/ExpenseForm.vue').default);
Vue.component('expense-cierre', require('./components/ExpenseCierre.vue').default);
Vue.component('tax-view', require('./pages/Tax.vue').default);
Vue.component('mensaje-receptor-lote', require('./components/MensajeReceptorLote.vue').default);
Vue.component('seller-tr', require('./components/SellerTr.vue').default);

Vue.component('product-providers-form', require('./components/ProductProvidersForm.vue').default);
Vue.component('proforma-purchase-form', require('./components/ProformaPurchaseForm.vue').default);

Vue.component('barcode-scanner', require('./components/BarcodeScanner.vue').default);

Vue.component('electronic-invoice', require('./components/ElectronicInvoiceForm.vue').default);

Vue.component('product-quantity', require('./components/ProductQuantity.vue').default);
Vue.component('duplicate-product-modal', require('./components/DuplicateProductModal.vue').default);


const app = new Vue({
    el: '#app'
});

$("form[data-confirm]").submit(function () {
    if (!confirm($(this).attr("data-confirm"))) {
        return false;
    }
});

$(".flatpickr").flatpickr({
    wrap:true
});
